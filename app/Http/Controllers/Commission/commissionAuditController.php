<?php

namespace App\Http\Controllers\Commission;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Excel;
use Mockery\Exception;

class commissionAuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示佣金列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageSize = Input::get('pageSize');
        $page = Input::get('page');
        $lpname = Input::get('xm');

        $limitStart=($page-1)*$pageSize;
        $limitEnd = $pageSize;
        $sql=" select *,case sqfk+sqfk1 when 0 then '首期房租押金已付齐' else '首期房租押金未付齐' end beizhu  from v_yjxx ";
        $strWhere=" where 1=1 ";
        if(!empty($lpname)){
            $strWhere=$strWhere." and CONCAT(loupan,loudong,fanghao)  like '%".$lpname."%'"  ;
        }
        $count =  DB::connection('mysql3')->select("select count(*) as countNum from v_yjxx ".$strWhere) ;
        $sql=$sql.$strWhere."   limit ".$limitStart.", ".$limitEnd;
        $bk = DB::connection('mysql3')->select($sql);

        return $data = ['total'=>$count[0]->countNum,'data'=>$bk];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *保存
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sql=" select *,case sqfk+sqfk1 when 0 then '首期房租押金已付齐' else '首期房租押金未付齐' end beizhu  from v_yjxx where id=".$id;

        $bk = DB::connection('mysql3')->select($sql);

        return $data = [ 'data'=>$bk[0]];
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
     *更新
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *删除
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
    /**
     * Update the specified resource in storage.
     *佣金审批
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auditComm(Request $request)
    {

        DB::connection('mysql3')->table('users')
            ->where('id', 1)
            ->update(['zt' => 1,'yijian' => '']);
        return 1;
    }
    /**
     * Update the specified resource in storage.
     *付款
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function  payComm(Request $request)
    {
        DB::connection('mysql3')->table('users')
            ->where('id', 1)
            ->update(['zt' => 1,'yijian' => '']);

        $u = Auth::user();
        $obj=    Array(
            'send_from_id'=>$u->id,
            'send_from_name'=>$u->name,
            'send_from_name'=>'erp',
            'send_to_id'=>$u->id,
            'send_to_name'=>$request->qvdao,
            'send_to_sys'=>'erp',
            'phone'=>$request->phone,
            'type'=>6,
            'is_message'=>1,
            'is_web'=>0,
            'yongjin'=>$request->yongjin,
        );
        //dd($obj);
        $client = new Client ([
            'base_uri' =>'',

        ]);

        $r = $client->request('POST', 'http://erp.youshikongjian.com/sendMessage', [
            'json' => $obj
        ]);
        return $r->getBody();
        return 1;
    }
}
