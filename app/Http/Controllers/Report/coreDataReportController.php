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

class coreDataReportController extends Controller
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

        $limitStart=($page-1)*$pageSize;
        $limitEnd = $pageSize;
        $sql="select *,DATEDIFF(kzdate,StartDate)kzts from v_hxsj ";
        $strWhere=" where 1=1 ";
        if(!empty($lpname)){
            $strWhere=$strWhere." and Loupan_name like '%".$lpname."%'"  ;
        }
        $count =  DB::connection('mysql2')->select("select count(*) as countNum from v_hxsj ".$strWhere) ;
        $sql=$sql.$strWhere." order by Loupan_name limit ".$limitStart.", ".$limitEnd;
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
        $lpname = Input::get('xm');
        $sql="select pname,fd_name,xmsx,Loupan_name,Loudong_name,Fanghao,Qianyuemianji,Price,saleprice,StartDate,cfdate,DATEDIFF(kzdate,StartDate)kzts,cfcs,ZhongzhiDate from v_hxsj  ";
        $strWhere=" where 1=1 ";
        if(!empty($lpname)){
            $strWhere=$strWhere." and Loupan_name like '%".$lpname."%'"  ;
        }
        $sql=$sql.$strWhere." order by  Loupan_name " ;
        try{
            $bk = DB::connection('mysql2')->select($sql);
        $cellData= $this->objToArray($bk);
        if(count($cellData)>0){
        $headerData=['区域','分区','类别','楼盘','楼栋','房间号','面积','收购单价',
            '出房单价','产品收房日','出房签约日','空置天数','出房次数','前租户房租截止日'];
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
