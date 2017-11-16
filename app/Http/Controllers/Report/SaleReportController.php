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

class SaleReportController extends Controller
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
        $lpzd=array("1"=>"礼品等级A","2"=>"礼品等级B","3"=>"礼品等级C","4"=>"礼品等级D","5"=>"礼品等级E");
        $sql="select pname,fd_name,`Name`,Phone,xmsx,Loupan_name,Loudong_name,Fanghao,Qianyuemianji,price,yuezujin,xsdj,xsyzj,ckzl,ckzlzj,QianyueDate,StartDate,EndDate,yjts,
case when yjts<10 then  yjts   when yjts BETWEEN 10 and 20 then 10-yjts   when yjts BETWEEN 21 and 35 then 21-yjts  when yjts>35 then 36-yjts end yjkxf,
case when yjts<10 then '荣誉房'   when yjts BETWEEN 10 and 20 then '快销房'   when yjts BETWEEN 21 and 35 then '风险房'  when yjts>35 then '亏损房' end yjjb,
zxsp, lpsort from v_fyxk ";
        $strWhere=" where 1=1 ";
        if(!empty($startdate)){
            $strWhere=$strWhere." and QianyueDate>='".$startdate."'"  ;
        }
        if(!empty($enddate)){
            $strWhere=$strWhere." and QianyueDate<='".$enddate."'"  ;
        }
        $count =  DB::connection('mysql2')->select("select count(*) as countNum from v_fyxk ".$strWhere) ;
        $sql=$sql.$strWhere." order by QianyueDate desc limit ".$limitStart.", ".$limitEnd;
        $bk = DB::connection('mysql2')->select($sql);
//        foreach ($bk as $key=>$value){
//            $lpsort = explode(";", $value->lpsort);
//            $lpdj='';
//            foreach ($lpsort as $k=>$val ) {
//                if(strlen($val)==1)
//                {
//                    $lpdj=$lpdj.$lpzd[$val];
//                }else{
//                    $lpdj=$lpdj.$val;
//                }
//
//            }
//            $bk[$key]->lpsort=$lpdj;
//        }


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
        $sql="select pname,fd_name,`Name`,Phone,xmsx,Loupan_name,Loudong_name,Fanghao,Qianyuemianji,price,yuezujin,xsdj,xsyzj,ckzl,ckzlzj,QianyueDate,StartDate,EndDate,yjts,
case when yjts<10 then  yjts   when yjts BETWEEN 10 and 20 then 10-yjts   when yjts BETWEEN 21 and 35 then 21-yjts  when yjts>35 then 36-yjts end yjkxf,
case when yjts<10 then '荣誉房'   when yjts BETWEEN 10 and 20 then '快销房'   when yjts BETWEEN 21 and 35 then '风险房'  when yjts>35 then '亏损房' end yjjb,
zxsp, lpsort from v_fyxk ";
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
            $lpzd=array("1"=>"礼品等级A","2"=>"礼品等级B","3"=>"礼品等级C","4"=>"礼品等级D","5"=>"礼品等级E");
//            foreach ($bk as $key=>$value){
//                $lpsort = explode(";", $value->lpsort);
//                $lpdj='';
//                foreach ($lpsort as $k=>$val ) {
//                    if(strlen($val)==1)
//                    {
//                        $lpdj=$lpdj.$lpzd[$val];
//                    }else{
//                        $lpdj=$lpdj.$val;
//                    }
//
//                }
//                $bk[$key]->lpsort=$lpdj;
//            }
        $cellData= $this->objToArray($bk);
        if(count($cellData)>0){
        $headerData=['区域','分区','联系人','电话','项目属性','楼盘','楼栋','房间号','面积','收购单价（元/㎡/天）',
            '收购月租金','销售底价','销售月租金','对外销售单价','对外销售月租金','收购签约日','免租期开始日','免租期结束日',
            '预警天数','风险房变亏损房预警天数','预警级别','装修状态','礼品等级'];
        array_unshift($cellData,$headerData);
        //dd($cellData);
        Excel::create('房源销控'.date("YmdHis"),function($excel) use ($cellData){
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
