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

        $limitStart=($page-1)*$pageSize;
        $limitEnd = $pageSize;
        $sql=" select lpid,lpname,mianji,totalNum,bzxzNum,bzyzNum,zdqjfy,minprice,maxprice,yearNum,weekNum,enum_key 
from t_projectweek_report tpw inner join t_enum on tpw.mianji=t_enum.enum_value and enum_name='mianji'
where yearNum = YEAR(NOW()) and weekNum=yearweek(now() )-1 ";
        $strWhere=" where 1=1 ";
        if(!empty($lpname)){
            $strWhere=$strWhere." and lpname like '%".$lpname."%'"  ;
        }
        $count =  DB::connection('mysql3')->select("select count(*) as countNum from t_projectweek_report where yearNum = YEAR(NOW()) and weekNum=yearweek(now() )-1 ".$strWhere) ;
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
        $sql="select lpname,xmzhs,xyzzhs,yzxyzhs,xyzzjbfb,xmzmj,xkzmj,xkzts,xkzmjbfb,xyzkzmj,xyzkzts,xyzamj,xyzats,xyzbmj,xyzbts,xyzcmj,xyzcts,ksgfyzmj,
      ksgfyzts,bzxzfymj,bzxzfyts,bzyzfymj,bzyzfyts,ysgfymj,ysgfyts,sgprice from t_projcet_report ";
        $strWhere=" where 1=1 ";
        if(!empty($lpname)){
            $strWhere=$strWhere." and lpname like '%".$lpname."%'"  ;
        }

        try{
            $bk = DB::connection('mysql3')->select($sql.$strWhere);

        $cellData= $this->objToArray($bk);
        if(count($cellData)>0){
        $headerData=['项目名称','项目总户数','小业主总户数','已知小业主房间总户数','小业主资料百分比','项目总面积','销控总面积','销控总套数','销控总面积百分比','小业主空置可出租房源面积',
            '小业主空置可出租房源套数','小业主45天之内到期可出租的面积','小业主45天之内到期可出租的套数','46到90天之内到期可出租面积','46到90天之内到期可出租套数','租户或资产管理公司转租约的面积',
            '租户或资产管理公司转租约的套数','可收购房源总面积', '可收购房源总套数','本周新增房源面积','本周新增房源套数','本周已租房源面积','本周已租房源套数',
            '已收购面积','已收购套数','已收购均价'];
        array_unshift($cellData,$headerData);
        //dd($cellData);
        Excel::create('项目汇总'.date("YmdHis"),function($excel) use ($cellData){
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
