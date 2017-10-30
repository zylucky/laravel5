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

class ChuFangReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示出房列表
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

        $sql="select * from v_cf ";
        $strWhere=" where 1=1 ";
        if(!empty($startdate)){
            $strWhere=$strWhere." and QianyueDate>='".$startdate."'"  ;
        }
        if(!empty($enddate)){
            $strWhere=$strWhere." and QianyueDate<='".$enddate."'"  ;
        }
        $count =  DB::connection('mysql2')->select("select count(*) as countNum from v_cf ".$strWhere) ;
        $sql=$sql.$strWhere." order by QianyueDate desc limit ".$limitStart.", ".$limitEnd;
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
        $sql="select * from v_cf ";
        $strWhere=" where 1=1 ";
        if(!empty($startdate)){
            $strWhere=$strWhere." and QianyueDate>='".$startdate."'"  ;

        }
        if(!empty($enddate)){
            $strWhere=$strWhere." and QianyueDate<='".$enddate."'"  ;

        }
        $sql=$sql.$strWhere." order by QianyueDate desc " ;
        try{
        $bk = DB::connection('mysql2')->select($sql);
        $cellData= $this->objToArray($bk);
        if(count($cellData)>0){
        $headerData=['区域','分区','产品类型','用友编号','楼盘','楼栋','房间号','面积','收房单价（元/㎡/天）',
            '收房月租金','收房免租天数','收房签约年限','签约年限','收房免租期','收房签约日期'];
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
