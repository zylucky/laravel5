<?php

namespace App\Http\Controllers\Report;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Excel;
use Mockery\Exception;

class daikanReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示带看列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageSize = Input::get('pageSize');
        $page = Input::get('page');
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $personname = Input::get('personname');
        $loupan= Input::get('loupan');
        $dep1 = Input::get('dep1');
        $limitStart=($page-1)*$pageSize;
        $limitEnd = $pageSize;
        $sql="select * from v_daikan ";
        $strWhere=" where 1=1 ";
        if(!empty($startdate)){
            $strWhere=$strWhere." and date(dakatime)>=date('".$startdate."')"  ;
        }
        if(!empty($enddate)){
            $strWhere=$strWhere." and date(dakatime)<=date('".$enddate."')"  ;
        }
        if(!empty($personname)){
            $strWhere=$strWhere." and personname like '%".$personname."%' "  ;

        }
        if(!empty($loupan)){
            $strWhere=$strWhere." and loupan like '%".$loupan."%' "  ;
        }
        if(!empty($dep1)){
            $strWhere=$strWhere." and dep1 like '%".$dep1."%' "  ;
        }
        $count =  DB::connection('mysql3')->select("select count(*) as countNum from v_daikan ".$strWhere) ;
        $sql=$sql.$strWhere." order by  dakatime desc limit ".$limitStart.", ".$limitEnd;
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


    //导出Excel
    public function ExportExcel()
    {
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $personname = Input::get('personname');
        $loupan= Input::get('loupan');
        $dep1 = Input::get('dep1');
        $sql="select dep1,dep2, loupan, loudong, fangjian, fjmj, ckzl, ckzlzj, kehuyetai,bangongrenshu,kehumianji,kehuyusuan,kehuqvyv,kehuyongfangshijian,shifoufuzeren,
 gongsi, renyuan, dianhua, sfek, shuoming,xiaciqvdaoshuoming , personname, phone,dakatime from v_daikan";
        $strWhere=" where 1=1 ";
        if(!empty($startdate)){
            $strWhere=$strWhere." and date(dakatime)>=date('".$startdate."')"  ;
        }
        if(!empty($enddate)){
            $strWhere=$strWhere." and date(dakatime)<=date('".$enddate."')"  ;
        }
        if(!empty($personname)){
            $strWhere=$strWhere." and personname like '%".$personname."%' "  ;
        }
        if(!empty($loupan)){
            $strWhere=$strWhere." and loupan like '%".$loupan."%' "  ;
        }
        if(!empty($dep1)){
            $strWhere=$strWhere." and dep1 like '%".$dep1."%' "  ;
        }
        try{
            $bk = DB::connection('mysql3')->select($sql.$strWhere);
        $cellData= $this->objToArray($bk);
        if(count($cellData)>0){
        $headerData=['区域','分区','楼盘','座栋','房号','房间面积','对外销售单价','对外销售月租金','客户业态','客户办公人数','客户面积','客户预算','客户所选择区域',
            '客户用房时间','是否客户负责人','渠道公司名称','渠道联系人','联系电话','是否二看','带看情况','客户意见','下次渠道推荐说明','幼狮带看人','联系电话','带看时间'];
        array_unshift($cellData,$headerData);
        //dd($cellData);
        Excel::create('客户带看'.date("YmdHis"),function($excel) use ($cellData){
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
