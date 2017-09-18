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
        $name = Input::get('bk_name');
        $yewuqvyvid = Input::get('yewuqvyvid');
        $yewupianqvid = Input::get('yewupianqvid');
        $gongsijingyingshuxing = Input::get('gongsijingyingshuxing');
        $hezuoxieyidengji = Input::get('hezuoxieyidengji');
        $xm = Input::get('xm');
        $sql = " select QD_PerName, zhiwu,tel,CompayName,gs_loupan, p.yslianxiren1, p.yslianxiren2,p.yslianxiren3, 
     IF(shifouweixin=0,'否','是'), tianjiahaoyourenshu, IF(shifoudaikanyoushi=0,'否','是'), daikancishu, 
    daikanduijierenshu, IF(shifouqianyueyoushifang=0,'否','是'), qianyuecishu, qianyueduijierenshu, qvdaodengji,p.beizhu
    from t_qd_person p LEFT JOIN t_qd_compay qd on p.T_QD_Compay_ID = qd.T_QD_Compay_ID
	left join (select personId,GROUP_CONCAT(dianhua)tel from t_qd_person_tel where qd_type=1 GROUP BY personId)dianhua on p.t_qd_person_id=dianhua.personId
    where 1=1  ";

        if (!empty($name)) {
            $sql = $sql . " and CompayName like '%" . $name . "%' ";

        }
        if (!empty($yewuqvyvid)) {
            $sql = $sql . " and yewuqvyvid =" . $yewuqvyvid;

        }
        if (!empty($yewupianqvid)) {
            $sql = $sql . " and yewupianqvid =" . $yewupianqvid;

        }
        if (!empty($gongsijingyingshuxing)) {
            $sql = $sql . " and INSTR(gongsijingyingshuxingId,'" . $gongsijingyingshuxing . ",')>0";

        }
        if (!empty($hezuoxieyidengji)) {
            $sql = $sql . " and hezuoxieyidengji =" . $hezuoxieyidengji;

        }
        if (!empty($xm)) {
            $sql = $sql . " and gs_loupan like '%" . $xm . "%' ";

        }
        try {
            $bk = DB::connection('mysql2')->select($sql);
            $cellData = $this->objToArray($bk);
            if (count($cellData) > 0) {
                $headerData = ['公司名称', '业务区域', '公司详细地址', '项目名称', '公司规模', '公司成立时间', '主做区域', '是否有过合作', '合作次数',
                    '是否签署协议', '签署协议时间', '合作协议等级', '幼狮联系人1', '幼狮联系人2', '幼狮联系人3', '法人姓名', '法人联系方式', '负责人姓名',
                    '负责人联系方式', '佣金类型', '收房佣金占比', '出房用尽占比', '公司经营属性', '服务对象'];
                array_unshift($cellData, $headerData);
                //dd($cellData);
                Excel::create('渠道公司' . date("YmdHis"), function ($excel) use ($cellData) {
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
