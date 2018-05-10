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

class jinggengReportController extends Controller
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

        $limitStart=($page-1)*$pageSize;
        $limitEnd = $pageSize;
        $sql="select * from v_jgfy ";

        $count =  DB::connection('mysql3')->select("select count(*) as countNum from v_jgfy ") ;
        $sql=$sql."  limit ".$limitStart.", ".$limitEnd;
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

        $sql=" select topic,zdh,fybh,fjmj,price,fjyzj,hyzt,kzzt,sfzc,yzsx,yzdh,kzztpg,bzxzfy,bzxzyz from v_jgfy ";

        try{
            $bk = DB::connection('mysql3')->select($sql);

        $cellData= $this->objToArray($bk);
        if(count($cellData)>0){
        $headerData=[ '楼盘','楼栋','房间号','面积','单价（元/㎡/天）',
            '月租金','航远房源','空置状态','支持注册','业主属性','业主电话','可租状态评估','本周新增',
            '本周已租','目标底价','租期年限','付款方式','免租期（天）','备注'];
        array_unshift($cellData,$headerData);
        //dd($cellData);
        Excel::create('精耕房源'.date("YmdHis"),function($excel) use ($cellData){
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
