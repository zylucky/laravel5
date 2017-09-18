<?php

namespace App\Http\Controllers\BrokerCompany;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Excel;
use Illuminate\Support\Facades\DB;

class brokerUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示渠道人员列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $yewuqvyvid=Input::get('yewuqvyvid');
        $yewupianqvid=Input::get('yewupianqvid');
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $qvdaodengji = Input::get('qvdaodengji');
        $username = Input::get('username');
        $pageSize = Input::get('pageSize');
        $page= Input::get('page');
        $tel= Input::get('bk_dianhua');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/ziyou/list',[
            'query' => [
                'page'=>$page,
                'size'=>$pageSize,
                'uname'=>$username,
                'ywqyid' => $yewuqvyvid,
                'ywpqid' => $yewupianqvid,
                'qddj' => $qvdaodengji,
                'sdate' => $startdate,
                'edate' => $enddate,
                'tel'=>$tel,
            ]
        ]);
        return $response->getBody();
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
     *保存渠道人员
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      //  dd( $request->params);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);

        $r = $client->request('POST', '/api/qd/ziyou/add', [
            'json' => $request->params
        ]);
        return  $r ->getBody();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/ziyou/' . $id . '/get', [
            ]
        );
        echo $response->getBody();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *更新渠道人员
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obj=$request->params;
         //dd( json_encode( $request->params, JSON_UNESCAPED_UNICODE));
        //dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);

        $r = $client->request('POST', '/api/qd/ziyou/alter', [
            'json' => $obj
        ]);
        return  $r ->getBody();
    }

    /**
     * Remove the specified resource from storage.
     *删除渠道人员
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return $this->deleteCompany($id);
    }

    public  function deleteCompany($id)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/person/{$$}/del');
        return $response->getBody();
    }
    /*
     * 批量删除
     * @param Request $request
     */
    public function batchRemoveBKUser(Request $request)
    {
        $ids = $request->params['ids'];

        $code='200';
        $arr = explode(',',$ids);
        foreach ($arr as $item ){
            $status= $this->deleteCompany($item);
            if($status->code!='200')
            {
                $code=$status->msg;
            }
        }
        return $code;
    }


    //停用启用自由人员状态
    public function changeBrokerCompanyUserStatus(Request $request)
    {
        $obj =$request->params ;

        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        if ($obj['status'] == 0) {
            $response = $client->request('GET', '/api/qd/ziyou/' . $obj['id'] .'/start', [
                ]
            );
            echo $response->getBody();
        } else {
            $response = $client->request('GET', '/api/qd/ziyou/' . $obj['id'] . '/stop', [
                ]
            );
            echo $response->getBody();
        }
    }
    //导出Excel
    public function ExportExcel()
    {
        $yewuqvyvid=Input::get('yewuqvyvid');
        $yewupianqvid=Input::get('yewupianqvid');
        $qvdaodengji = Input::get('qvdaodengji');
        $username = Input::get('username');
        $tel= Input::get('bk_dianhua');
        $sql = " select  xingming, tel,CONCAT(yewuqvyv,yewupianqv)ywqy, yslianxiren1,yslianxiren2,  yslianxiren3,
    IF(shifouweixin,'否','是'), tianjiahaoyourenshu, IF(shifoudaikanyoushi,'否','是'), daikancishu, daikanduijierenshu, 
    IF(shifoudaikanyoushifang,'否','是'), qianyuecishu, qianyueduijierenshu, qvdaodengji,  case YJ_Type when 1 then '按月租金' when 2 then '按年租金' end, 
    YJZB_SF, YJZB_CF,beizhu
    from t_qd_zy_person p
	left join (select personId,GROUP_CONCAT(dianhua)tel from t_qd_person_tel where qd_type=2 GROUP BY personId)dianhua 
	on p.t_qd_zy_person_id=dianhua.personId where 1=1  ";

        if (!empty($username)) {
            $sql = $sql . " and xingming like '%" . $username . "%' ";

        }
        if (!empty($yewuqvyvid)) {
            $sql = $sql . " and yewuqvyvid =" . $yewuqvyvid;

        }
        if (!empty($yewupianqvid)) {
            $sql = $sql . " and yewupianqvid =" . $yewupianqvid;

        }
        if (!empty($qvdaodengji)) {
            $sql = $sql . " and qvdaodengji =" . $qvdaodengji;

        }
        if (!empty($tel)) {
            $sql = $sql . " and tel like '%" . $tel . "%' ";

        }
        try {
            $bk = DB::connection('mysql2')->select($sql);
            $cellData = $this->objToArray($bk);
            if (count($cellData) > 0) {
                $headerData = ['姓名','联系电话','业务区域','','幼狮联系人1','幼狮联系人2','幼狮联系人3','是否添加微信好友','添加好友人数','是否带看幼狮','带看次数','带看对接人数',
                    '是否签约过幼狮','签约次数','签约对接人数','粘性等级','佣金类型','收房佣金占比','出房佣金占比','备注'];
                array_unshift($cellData, $headerData);
                //dd($cellData);
                Excel::create('自由经纪人' . date("YmdHis"), function ($excel) use ($cellData) {
                    $excel->sheet('score', function ($sheet) use ($cellData) {
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                echo "导出成功";
            } else {
                echo "无符合条件的数据";
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
