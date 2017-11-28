<?php

namespace App\Http\Controllers\BrokerCompany;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Excel;
use Mockery\Exception;

class brokerCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示渠道公司列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = Input::get('bk_name');
        $pageSize = Input::get('pageSize');
        $page = Input::get('page');
        $yewuqvyvid=Input::get('yewuqvyvid');
        $yewupianqvid=Input::get('yewupianqvid');
        $gongsijingyingshuxing=Input::get('gongsijingyingshuxing');
        $hezuoxieyidengji= Input::get('hezuoxieyidengji');
        $pname= Input::get('pname');
        $parentid= Input::get('parentid');
        $xm= Input::get('xm');
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/qd/compay/list', [
                'query' => [
                    'page' => $page,
                    'size' => $pageSize,
                    'compay' => $name,
                    'ywqyid' => $yewuqvyvid,
                    'ywpqid' => $yewupianqvid,
                    'jysx' => $gongsijingyingshuxing,
                    'xydj' => $hezuoxieyidengji,
                    'xm' => $xm,
                    'pname' => $pname,
                    'parentid' => $parentid,
                ]

            ]
        );
        echo $response->getBody();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $info = Input::get();
//        if($info) {
//              return [
//                        'message' => '保存成功',
//                        'code' => 200,
//              ];
//        }

    }

    /**
     * Store a newly created resource in storage.
     *保存渠道公司
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->params);
        $user = Auth::user();
        $obj = array_merge($request->params, Array('tbPersonIdCreate' =>$user->id));
        //dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);

        $r = $client->request('POST', '/api/qd/compay/add', [
            'json' => $obj
        ]);
        return $r->getBody();

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/compay/' . $id . '/get', [


            ]
        );
        echo $response->getBody();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *更新渠道公司
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $obj = $request->params;
        //dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);

        $r = $client->request('POST', '/api/qd/compay/alter', [
            'json' => $obj
        ]);
        return $r->getBody();
    }

    /**
     * Remove the specified resource from storage.
     *删除渠道公司
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);

        return $this->deleteCompany($id);
    }

    public function deleteCompany($id)
    {

        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/compay/' . $id . '/del'

        );
        echo $response->getBody();
    }

    public function batchRemoveBrokerCompany(Request $request)
    {
        $ids = $request->params['ids'];
        $code = '200';
        $arr = explode(',', $ids);

        foreach ($arr as $item) {
            // dd($item);
            $status = $this->deleteCompany($item);
            if ($status->code != '200') {
                $code = $status->msg;
            }
        }
        return $code;
        // destroy($arr);
    }

    public function checkbkNameList(Request $request)
    {
        // dd($request->params['name']);
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $bkName = $request->params['name'];

        $response = $client->request('GET', '/api/qd/compay/check', [
                'query' => [
                    'compay' => $bkName
                ]

            ]
        );
        //dd($response->getBody());


        echo $response->getBody();

    }

    //公司经营属性
    public function getGSSXDicList(Request $request)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/comm/compay/jysx/list', [
            ]
        );
        echo $response->getBody();
    }

    //服务对象
    public function getFWDXDicList(Request $request)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/comm/compay/fwdx/list', [
            ]
        );
        echo $response->getBody();
    }

    //业务区域
    public function getYWQYDicList(Request $request)
    {

        $parentid = $request->params['parentid'];
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);

        $response = $client->request('GET', '/api/area/searchbusiness', [
                'query' => [
                    'parentid' => $parentid
                ]
            ]
        );

        echo $response->getBody();
    }

    //行政区域
    public function getXZQYDicList(Request $request)
    {
        $code = $request->params['code'];
        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/area/searchcity', [
                'query' => [
                    'code' => $code
                ]
            ]
        );
        echo $response->getBody();
    }

    //根据行政区域获取街道
    public function getJDDicList(Request $request)
    {
        $code = $request->params['code'];

        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/area/searchcity', [
                'query' => [
                    'code' => $code
                ]]
        );
        echo $response->getBody();
    }

    //协议等级
    public function getXYDJDicList(Request $request)
    {
        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/comm/compay/xydj/list', [
            ]
        );
        echo $response->getBody();
    }

    //幼狮联系人
    public function getYSLXRDicList(Request $request)
    {
        $uname = $request->params['uname'];
        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/base/search/person', [
                'query' => [
                    'uname' => $uname
                ]]
        );
        $obj = json_decode($response->getBody());
        $json = [];
        if ($obj->code == 200) {
            foreach ($obj->data as $key => $value) {
                $json[$value->id] = $value->name;
            }
            return $json;
        }
        //  echo $response->getBody();
    }

    //停用启用渠道公司状态
    public function changeBrokerCompanyStatus(Request $request)
    {
        $obj = $request->params;
        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        if ($obj['status'] == 1) {
            $response = $client->request('GET', '/api/qd/compay/' . $obj['id'] .'/start', [
                ]
            );
            echo $response->getBody();
        } else {
            $response = $client->request('GET', '/api/qd/compay/' . $obj['id'] . '/stop', [
                ]
            );
            echo $response->getBody();
        }
    }
    //导出Excel
    public function ExportExcel()
    {
        $name = Input::get('bk_name');
        $yewuqvyvid=Input::get('yewuqvyvid');
        $yewupianqvid=Input::get('yewupianqvid');
        $gongsijingyingshuxing=Input::get('gongsijingyingshuxing');
        $hezuoxieyidengji= Input::get('hezuoxieyidengji');
        $xm= Input::get('xm');
        $sql="select CompayName,CONCAT(yewuqvyv,yewupianqv)ywqy,CONCAT('北京市',dz_xingzhengqvyv,dz_jiedao,dz_xiangxi)addr,gs_loupan,gs_guimo,gs_chenglishijian,zhuzuoqvyv,
IF(shifouhezuoguo=0,'否','是')sfhz,hezuocishu,IF(shifouhezuoxieyi=0,'否','是')sfqy,qianxieyishijian,hezuoxieyidengji,yslianxiren1,yslianxiren2,yslianxiren3, farenxingming,farenlianxifangshi,fuzeren,fuzerenlianxifangshi,
case YJ_Type when 1 then '按月租金' when 2 then '按年租金' end,
YJZB_SF,YJZB_CF,gongsijingyingshuxing,fuwuduixiang
from t_qd_compay where 1=1 ";

        if(!empty($name)){
            $sql=$sql." and CompayName like '%".$name."%' ";

        }
        if(!empty($yewuqvyvid)){
            $sql=$sql." and yewuqvyvid =".$yewuqvyvid;

        }
        if(!empty($yewupianqvid)){
            $sql=$sql." and yewupianqvid =".$yewupianqvid;

        }
        if(!empty($gongsijingyingshuxing)){
            $sql=$sql." and INSTR(gongsijingyingshuxingId,'".$gongsijingyingshuxing.",')>0" ;

        }
        if(!empty($hezuoxieyidengji)){
            $sql=$sql." and hezuoxieyidengji =".$hezuoxieyidengji ;

        }
        if(!empty($xm)){
            $sql=$sql." and gs_loupan like '%".$xm."%' ";

        }
        try{
        $bk = DB::connection('mysql3')->select($sql);
        $cellData= $this->objToArray($bk);
        if(count($cellData)>0){
        $headerData=['公司名称','业务区域','公司详细地址','项目名称','公司规模','公司成立时间','主做区域','是否有过合作','合作次数',
            '是否签署协议','签署协议时间','合作协议等级','幼狮联系人1','幼狮联系人2','幼狮联系人3','法人姓名','法人联系方式','负责人姓名',
            '负责人联系方式','佣金类型','收房佣金占比','出房用尽占比','公司经营属性','服务对象'];
        array_unshift($cellData,$headerData);
        //dd($cellData);
        Excel::create('渠道公司'.date("YmdHis"),function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
            echo "导出成功";
        }else{
            echo "无符合条件的数据";
        }
        }catch (Exception $ex){
            echo $ex->getMessage();
        }


    }
}
