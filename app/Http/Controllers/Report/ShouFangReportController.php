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

class ShouFangReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示渠道公司列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageSize = Input::get('pageSize');
        $page = Input::get('page');
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');


        $limitStart=($page-1)*$pageSize;
        $limitEnd = $pageSize;

        $sql="select * from v_sf where 1=1 ";

        if(!empty($startdate)){
            $sql=$sql."and QianyueDate>='".$startdate  ;

        }
        if(!empty($enddate)){
            $sql=$sql."and QianyueDate<='".$enddate  ;

        }
        $count =  DB::connection('mysql2')->select("select count(*) as countNum from v_sf where 1=1 ") ;
        $sql=$sql."order by QianyueDate desc limit ".$limitStart.", ".$limitEnd;
        $bk = DB::connection('mysql2')->select($sql);
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
        $sql="select * from v_sf where 1=1 ";
        if(!empty($startdate)){
            $sql=$sql."and QianyueDate>='".$startdate  ;
        }
        if(!empty($enddate)){
            $sql=$sql."and QianyueDate<='".$enddate  ;

        }
        $sql=$sql."order by QianyueDate ";
        try{
        $bk = DB::connection('mysql2')->select($sql);
        $cellData= $this->objToArray($bk);
        if(count($cellData)>0){
        $headerData=['公司名称','业务区域','公司详细地址','项目名称','公司规模','公司成立时间','主做区域','是否有过合作','合作次数',
            '是否签署协议','签署协议时间','合作协议等级','幼狮联系人1','幼狮联系人2','幼狮联系人3','法人姓名','法人联系方式','负责人姓名',
            '负责人联系方式','佣金类型','收房佣金占比','出房用尽占比','公司经营属性','服务对象'];
        array_unshift($cellData,$headerData);
        //dd($cellData);
        Excel::create('收购'.date("YmdHis"),function($excel) use ($cellData){
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
