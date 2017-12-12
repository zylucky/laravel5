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

class projectSaleReportController extends Controller
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
        $lpname = Input::get('xm');
        $weekNum = Input::get('weekNum');
        $limitStart=($page-1)*$pageSize;
        $limitEnd = $pageSize;
        $sql=" select lpid,lpname,mianji,totalNum,bzxzNum,bzyzNum,zdqjfy,minprice,maxprice,yearNum,weekNum,enum_key 
from t_projectweek_report tpw inner join t_enum on tpw.mianji=t_enum.enum_value and enum_name='mianji'";
        $strWhere=" where 1=1 ";
        if(!empty($lpname)){
            $strWhere=$strWhere." and lpname like '%".$lpname."%'"  ;
        }
        if(!empty($weekNum)){
            $strWhere=$strWhere." and weekNum =yearweek('".$weekNum."')"  ;
        }
        $count =  DB::connection('mysql3')->select("select count(*) as countNum from t_projectweek_report   ".$strWhere) ;
        $sql=$sql.$strWhere." order by  lpid,mianji limit ".$limitStart.", ".$limitEnd;
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
        $lpname = Input::get('xm');
        $sql=" select lpname,enum_key,totalNum,bzxzNum,bzyzNum,zdqjfy,minprice,maxprice 
from t_projectweek_report tpw inner join t_enum on tpw.mianji=t_enum.enum_value and enum_name='mianji'";
        $strWhere=" where 1=1 ";
        if(!empty($lpname)){
            $strWhere=$strWhere." and lpname like '%".$lpname."%'"  ;
        }
        if(!empty($weekNum)){
            $strWhere=$strWhere." and weekNum =yearweek('".$weekNum."')"  ;
        }
        try{
            $bk = DB::connection('mysql3')->select($sql.$strWhere.'  order by  lpid,mianji ');

        $cellData= $this->objToArray($bk);
        if(count($cellData)>0){
        $headerData=['项目名称','面积','总套数','本周新增套数','本周已租套数','最低价格区间房源','最低价格','最高价格' ];
        array_unshift($cellData,$headerData);
        //dd($cellData);
        Excel::create('八周收购房源最低价格对比表'.date("YmdHis"),function($excel) use ($cellData){
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
