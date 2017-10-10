<?php

namespace App\Http\Controllers\Contract;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class purchaseContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pn = Input::get('pn');
        $cnt = Input::get('cnt');
        $selectItem = Input::get('selectItem');
        $status = Input::get('zhuangtai');
        if(!$pn){
            $pn = 1;
        }
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
            $response = $client->request('GET', '/api/contract/sf/list',[
                'query'=>[
                    'pn'=>$pn,
                    'cnt'=>$cnt,
                    'selectItem'=>$selectItem,
                    'status'=>$status,
                    ]
            ]);
            echo $response->getBody();
    }

    /**
     * Show the form for creating a new resource.
     *    合同新增的时候获取条款信息
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/sf/create');
        echo $response->getBody();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->params;
        //数据格式化
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $data = $request->params;
        
        $data['jiafangfeiyong'] = implode(',',$data['jiafangfeiyong']);
        $data['yifangfeiyong'] = implode(',',$data['yifangfeiyong']);
        $response = $client->request('POST', '/api/contract/sf/save', [
            'json' => $data,
        ]);
        $res = $response->getBody();
        $res = json_decode($res);
        $res->data->yifangfeiyong = explode(',',$res->data->yifangfeiyong);
        $res->data->jiafangfeiyong = explode(',',$res->data->jiafangfeiyong);
        echo json_encode($res)  ;
    }

    /**
     * Display the specified resource.
     * 根据合同ID获取合同的信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id);
        $res = $response->getBody();
        $res = json_decode($res);
        if($res->code!='200'){
            echo $response->getBody();
            exit;
        }
        $res->data->yifangfeiyong = explode(',',$res->data->yifangfeiyong);
        $res->data->jiafangfeiyong = explode(',',$res->data->jiafangfeiyong);
        $obj = $this->get_month_day($res->data->startdate,$res->data->enddate);
        //计算所有的免租期之和
        $free_month=0;
        $free_day=0;
        if(count($res->data->mianzuqiList)>0){
            foreach ($res->data->mianzuqiList as $key=>$value){
                $free_month += $this->get_month_day($value->startdate,$value->enddate)->m;
                $free_day += $this->get_month_day($value->startdate,$value->enddate)->d;
            }
        }
        if($free_day>30){
            $free_month += intval($free_day/30);
            $free_day = $free_day%30;
        }
        $res->data->nian = $obj->y;
        $res->data->yue = $obj->m;
        $res->data->ri = $obj->d;
        $res->data->free_month = $free_month;
        $res->data->free_day  = $free_day;
        echo json_encode($res)  ;
    }

    /**
     * Show the form for editing the specified resource.
     * 提交的时候，先根据楼栋的id取获取 objareaID，然后再根据获取到的东西去服务创建审核任务
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bianhao = Input::get('bianhao');
        $zd = Input::get('zd');
        //0.将合同提交
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response1 = $client->request('GET', '/api/contract/sf/'.$id.'/submit');
        //1.根据楼栋的id取获取 objareaID
        $client = new Client ([
            'base_uri' => $this->work_url,
        ]);
        $response = $client->request('GET', '/api/wf/getzdareaid?zd='.$zd);
        $objareaid = $response->getBody()->getContents();
        $data = [
            "cmd"=>0,
            "data"=>[
                "tempname"=>"shenhe",
                "objareaid"=>(int)$objareaid,
            ],
            "condition"=>["%bianhao%"=>$bianhao],
            "operatorId"=>15,//操作人
            "operatorName"=>'liyuequn',
            "reserved"=>null,
        ];
        //2.服务创建审核任务
        $client = new Client([
            'base_uri' => $this->work_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        //return $data;
        $client->request('POST', '/api/wf/createtaskbytemplate', [
            'json' => $data
        ]);

        echo $response1->getBody();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * 二次优化
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/sf/buchongXieyi/save', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /*
     * 合同审核
     *
     * */
    public function review(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);

        $response = $client->request('POST', '/api/contract/sf/shenhe', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    /*
     * 修改合同条款api/contract/hetong/update/tiao
     * */
    public function editTiaoKuan(Request $request){
        $data['id'] = $request->params['id'];
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        //条
        if(array_key_exists('kuanList', $request->params)){
            $requestUrl = '/api/contract/hetong/update/tiao';
            $data['title'] = $request->params['title'];
        }
        //款
        if(array_key_exists('xiangList', $request->params)){
            $requestUrl = '/api/contract/hetong/update/kuan/id/'.$data['id'];
            $data['content'] = $request->params['content'];
        }
        //项
        if(array_key_exists('kuanid', $request->params)){
            $requestUrl = '/api/contract/hetong/update/xiang';
            $data['content'] = $request->params['content'];
        }
        $response = $client->request('POST', $requestUrl, [
            'json' => $data
        ]);
        echo $response->getBody();
    }
    //合同状态变为：已确认
    public function confirm(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/confirm');
        echo $response->getBody();
    }
    //合同状态变为：待确认
    public function confirming(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/confirming');
        echo $response->getBody();
    }
    //合同状态变为：违约处理中
    public function violating(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/violating');
        echo $response->getBody();
    }
    //合同状态变为：合同终止
    public function terminated(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/terminated');
        echo $response->getBody();
    }
    //合同状态变为：优化中
    public function releasing(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/releasing');
        echo $response->getBody();
    }
    //合同状态变为：优化成功  执行两个动作：协议改为已提交的状态，合同改为已经优化的状态
    public function released(){
        $id = Input::get('hetongid');
        $xyid = Input::get('xyid');

        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/released');
        $response = $client->request('GET', '/api/contract/sf/buchongXieyi/'.$xyid.'/confrim?id='.$xyid);
        echo $response->getBody();
    }
    //优化协议的列表
    public function releasedList(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response1 = $client->request('POST', 'api/contract/sf/buchongXieyi/query?hetongId='.$id);
        //根据合同id获取房间信息
        $response2 = $client->request('GET', '/api/contract/sf/'.$id);
        $res = $response2->getBody();
        $res = json_decode($res);
        $loupan = $res->data->officeList[0]->loupanName;
        $loudong = $res->data->officeList[0]->loudongName;
        $fanghao = $res->data->officeList[0]->fanghao;
        $bianhao = $res->data->bianhao;

        $res = $response1->getBody();
        $res = json_decode($res);
        foreach ($res->data as $key=>$value){
            $value->loupanName = $loupan;
            $value->loudongName = $loudong;
            $value->fanghao = $fanghao;
            $value->bianhao = $bianhao;
        }
      echo json_encode($res);

    }
    //状态变更为审核中
    public function approving(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', "/api/contract/sf/$id/approving");
        echo $response->getBody();
    }
    /*
     * /api/contract/sf/buchongXieyi/3
     * 获取该合同的优化协议
     * */
    public function getOptimize(){
        $id = Input::get('id');
        $hetongid = Input::get('hetongid');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);

        if($hetongid){
            $url = '/api/contract/sf/buchongXieyi?hetongId='.$hetongid;
        }elseif($id){
            $url = '/api/contract/sf/buchongXieyi?id='.$id;
        }
        $response = $client->request('GET',$url );
        echo $response->getBody();
    }
    //合同终止的时候提交合同ID，然后获取应付信息
    public function weiYueInfo(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/cw/comm/inithtwy', [
            'json' => $request->params
        ]);
        echo $response->getBody();

    }
    /*
     * api/contract/sf/weiyue/save
     * */
    public function weiYueSave(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/sf/weiyue/save', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    /*isCopyComplete
     * 扫描合同复印件列表copyImageList
     * */
    public function copyImageList(Request $request){
        $id = Input::get('id');
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('GET', '/api/contract/sf/img/'.$id.'/query', [

        ]);
        $res = json_decode($response->getBody());
        if($res->data){
            $data2 = [];
            foreach ($res->data as $key => $value){
                //新文件名
                $value->url = 'http://www.youshikongjian.com'.$value->path;
                $value->content =null;
                $data2[$value->type][] = $value;
            }
            $res->data = $data2;
            echo json_encode($res);
        }
    }

    public function addCopyImage(){
        //PHP上传失败
        if (!empty($_FILES['file']['error'])) {
            switch($_FILES['file']['error']){
                case '1':
                    $error = '超过php.ini允许的大小。';
                    break;
                case '2':
                    $error = '超过表单允许的大小。';
                    break;
                case '3':
                    $error = '图片只有部分被上传。';
                    break;
                case '4':
                    $error = '请选择图片。';
                    break;
                case '6':
                    $error = '找不到临时目录。';
                    break;
                case '7':
                    $error = '写文件到硬盘出错。';
                    break;
                case '8':
                    $error = 'File upload stopped by extension。';
                    break;
                case '999':
                default:
                    $error = '未知错误。';
            }
            return $error;
        }
        $fp = fopen($_FILES["file"]["tmp_name"],"rb");
        $image = fread($fp,$_FILES["file"]["size"]);
        $image = base64_encode($image);
        $data = [
            'hetongid'=>$_POST['id'],
            'type'=>$_GET['type'],
            'content'=>$image,
        ];
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/sf/img/upload', [
            'json' =>$data
        ]);
        echo $response->getBody();
    }
    /*
     * 删除图片
     * */
    public function deleteCopyImage(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/sf/img/'.$id.'/del/');
        echo $response->getBody();

    }
    /*
     * 资料是否齐全
     * /api/contract/sf/img/set
     * */
    public function isCopyComplete(Request $request){
//        return $request->params;
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/sf/img/set', [
            'json' =>$request->params
        ]);
        echo $response->getBody();
    }
    public function getCopyComplete(){
        $id = Input::get('id');
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('GET', '/api/contract/sf/img/'.$id.'/isComplete');
        echo $response->getBody();
    }
    /**
     * 计算两个日期之间差几年几个月几天
     * @param  [string] $date1 [2000-11-05]
     * @param  [string] $date2 [2000-11-05]
     * @return [arr]        [
     *    t => year
     *    m => month
     *    d => day
     * ]
     */
    public function get_month_day($startdate,$enddate)
    {
        $startdate = $startdate/1000;
        $startdate = date_create(date('Y-m-d',$startdate));
        $enddate  = $enddate/1000+86400;//加一天
        $enddate = date_create(date('Y-m-d',$enddate));
        $bian = date_diff($startdate,$enddate);
        return $bian;
    }
    //付款账号的提交
    public function zhanghaoSave(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/yhzh/add', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    //付款账号的提交
    public function zhanghaoAlter(Request $request){
        //dd(33333);
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/yhzh/alter', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    //获取账号数据列表
    public function getZhanghaoList()
    {
        $htid = Input::get('htid');
        $page = Input::get('page');
        $size = Input::get('size');
        $httid = Input::get('httid');
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/yhzh/list',
            [
                'query' => [
                    'htid' => $htid,
                    'httid' =>  $httid,
                    'page' => $page,
                    'size' => $size,
                ]
            ]
    );
        echo $response->getBody();
        /*if(!$page){
            $pn = 1;
        }*/
    }
    public function deleteZhanghao(Request $request){
        $id = Input::get('id');
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('GET', '/api/contract/yhzh/'.$id.'/delete');
        echo $response->getBody();
    }
    //合单的提交
    public function hedanSave(Request $request){
        //dd(33333);
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/sf/splitbill/create', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    //获取合单数据列表
    public function getHedanList()
    {
        //dd(12121);
        $id = Input::get('htid');
        $pn = Input::get('pn');
        $cnt = Input::get('cnt');
        //dd($id);
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/sf/splitbill/query?id='.$id.'&pn='.$pn.'&cnt='.$cnt);
        echo $response->getBody();

    }
    public function deleteHedan(){
        //dd(111);
        $id = Input::get('id');
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('GET', '/api/contract/sf/splitbill/delete?id='.$id);
        echo $response->getBody();
    }
    public function updataHedan(Request $request){
        //dd(22);
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/sf/splitbill/update', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    //用友编号的保存
    public function saveyongyou(Request $request){
        //dd(111);
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/sf/saveyongyou', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    public function summary(){
        $id = Input::get('id');
        $httype = Input::get('httype');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/cw/proof/get?htid='.$id.'&httype='.$httype);
        echo $response->getBody();

    }

}
