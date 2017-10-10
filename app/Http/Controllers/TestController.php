<?php

namespace App\Http\Controllers;

use App\models\Role;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use Qiniu\Auth;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo $this->binToDec('10100010');exit;

        $bk = DB::connection('mysql2')->select("select CompayName,CONCAT(yewuqvyv,yewupianqv)ywqy,CONCAT('北京市',dz_xingzhengqvyv,dz_jiedao,dz_xiangxi)addr,gs_loupan,gs_guimo,gs_chenglishijian,zhuzuoqvyv,
IF(shifouhezuoguo=0,'否','是')sfhz,hezuocishu,IF(shifouhezuoxieyi=0,'否','是')sfqy,qianxieyishijian,hezuoxieyidengji,yslianxiren1,yslianxiren2,yslianxiren3, farenxingming,farenlianxifangshi,fuzeren,fuzerenlianxifangshi,
case YJ_Type when 1 then '按月租金' when 2 then '按年租金' end,
YJZB_SF,YJZB_CF,gongsijingyingshuxing,fuwuduixiang
from t_qd_compay");
        $cellData= $this->objToArray($bk);
        $headerData=['公司名称','业务区域','公司详细地址','项目名称','公司规模','公司成立时间','主做区域','是否有过合作','合作次数',
            '是否签署协议','签署协议时间','合作协议等级','幼狮联系人1','幼狮联系人2','幼狮联系人3','法人姓名','法人联系方式','负责人姓名',
            '负责人联系方式','佣金类型','收房佣金占比','出房用尽占比','公司经营属性','服务对象'];
        array_unshift($cellData,$headerData);
        exit;
        //dd($cellData);
        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');

        dd($this->objToArray($bk));
        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
       exit;
    })->export('xls');
       $hello =  DB::connection('mysql2')->table('t_shoufanghetong')->find(3091);
       dd($hello);



    }

    public function objToArray($data){
        //1.获取数据
        $data2 = [];
        foreach ($data as $key=>$value){
            foreach ($value as $k=>$v){
                $data2[$key][] = $v;
            }
        }
        return $data2;
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return 1;
        $fp = fopen($_FILES["file"]["tmp_name"],"rb");
        $image = fread($fp,$_FILES["file"]["size"]);
        $image = base64_encode($image);
        $data = [
            'id'=>$_POST['id'],
            'type'=>$_GET['type'],
            'image'=>$image,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function removeDir($dirName)
    {
        if(! is_dir($dirName))
        {
            return false;
        }
        $handle = @opendir($dirName);
        while(($file = @readdir($handle)) !== false)
        {
            if($file != '.' && $file != '..')
            {
                $dir = $dirName . '/' . $file;
                is_dir($dir) ? removeDir($dir) : @unlink($dir);
            }
        }
        closedir($handle);

        return rmdir($dirName) ;
    }
    public function  mHash($key){
        $md5=substr(md5($key),0,8);
        $seed=31;
        $hash=0;
        for ($i=0;$i<8;$i++){
            $hash=$hash*$seed+ord($md5{$i});
        }
        return $hash&0x7FFFFFFF;
    }

    public  function binToDec($num){
        $length = strlen($num);
        $value = 0;
        $n = $length;
        for ($i=0;$i<$length;$i++){
            $value += (int)$num[$i]*pow(2,$n-1);
            $n--;
        }
        return $value;
    }

}
