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

class chanPinHeYueReportController extends Controller
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

        $sql="select Quyu,Fenqu,case HetongTID when 0 then '业主' when 1 then '租户' end as zuhuyezu,Leixing,YongyouID,LoupanName,LoudongName,Fanghao,Mianji,num,Qynx,
ShouChuFangDate,QianYueDate,QYZQ,EndDate,MianZuQi,MianZuDays,MianZuFS,
FKFS,ZJXX,DiZengDate,DiZengLiang,Price,YaJin,NowYueZuJin,NowPrice,NowPriceCha,NowZuJinCha,JuJianFang,HeDan,ChanQuanZhengHao,WeiZhi,XingMing,LianXiFangShi,StateDate from t_chanpinheyue  ";
        $strWhere=" where 1=1 ";
        if(!empty($startdate)){
            $strWhere=$strWhere." and QianyueDate>='".$startdate."'"  ;
        }
        if(!empty($enddate)){
            $strWhere=$strWhere." and QianyueDate<='".$enddate."'"  ;
        }
        $count =  DB::connection('mysql2')->select("select count(*) as countNum from t_chanpinheyue ".$strWhere) ;
        $sql=$sql.$strWhere." order by LoupanName,LoudongName,Fanghao,QianYueDate limit ".$limitStart.", ".$limitEnd;
        $bk = DB::connection('mysql2')->select($sql);
        foreach ($bk as $key=>$value){

            $startdate = date_create( $value->StateDate);
            $enddate = date_add(date_create( $value->EndDate ),date_interval_create_from_date_string('1 day') );
            $qynx=date_diff($startdate,$enddate);
            $bk[$key]->Qynx=$qynx->y.'年'.$qynx->m.'月'.$qynx->d.'日';
        }
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
        $sql="select Quyu,Fenqu,case HetongTID when 0 then '业主' when 1 then '租户' end as zuhuyezu,Leixing,YongyouID,LoupanName,LoudongName,Fanghao,Mianji,num,Qynx,
ShouChuFangDate,QianYueDate,QYZQ,EndDate,MianZuQi,MianZuDays,MianZuFS,
FKFS,ZJXX,DiZengDate,DiZengLiang,Price,YaJin,NowYueZuJin,NowPrice,NowPriceCha,NowZuJinCha,JuJianFang,HeDan,ChanQuanZhengHao,WeiZhi,XingMing,LianXiFangShi,StateDate from t_chanpinheyue  ";
        $strWhere=" where 1=1 ";
        if(!empty($startdate)){
            $strWhere=$strWhere." and QianyueDate>='".$startdate."'"  ;

        }
        if(!empty($enddate)){
            $strWhere=$strWhere." and QianyueDate<='".$enddate."'"  ;

        }
        $sql=$sql.$strWhere."  order by LoupanName,LoudongName,Fanghao,QianYueDate " ;
        try{
        $bk = DB::connection('mysql2')->select($sql);
            foreach ($bk as $key=>$value){

                $startdate = date_create( $value->StateDate);
                $enddate = date_add(date_create( $value->EndDate ),date_interval_create_from_date_string('1 day') );
                $qynx=date_diff($startdate,$enddate);
                $bk[$key]->Qynx=$qynx->y.'年'.$qynx->m.'月'.$qynx->d.'日';
                unset($bk[$key]->StateDate) ;
            }
        $cellData= $this->objToArray($bk);
        if(count($cellData)>0){
        $headerData=['区域','分区','业主/租户','产品类型','用友编号','楼盘','楼栋','房间号','面积','房间数量','签约年限','收房/出房日',
            '签约日','合同租期','到期日','免租期','免租天数','免租期扣除方式','付款方式','租期/租金','递增日','递增量','单价（元/㎡/天）',
            '业主/租户押金','当前月租金','当前单价','单价差额','租金差额','渠道公司名称+姓名','签约支持','产权证号','房屋坐落',
            '业主/租户姓名','业主/租户联系方式' ];
        array_unshift($cellData,$headerData);
        //dd($cellData);
        Excel::create('产品合约'.date("YmdHis"),function($excel) use ($cellData){
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
