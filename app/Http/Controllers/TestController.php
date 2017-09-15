<?php

namespace App\Http\Controllers;

use App\models\Role;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
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
        $server1 = '192.168.1.1';
        $server2 = '192.168.1.2';
        $server3 = '192.168.1.3';
        $server4 = '192.168.1.4';
        $server5 = '192.168.1.5';
        $server6 = '192.168.1.6';
        $key1= 'key1';
        $key2= 'key2';
        $data = [];
        $data2 = [];
        $data[$server1] =  $this->mHash($server1);
        $data[$server2] =  $this->mHash($server2);
        $data[$server3] =  $this->mHash($server3);
        $data[$server4] =  $this->mHash($server4);
        $data[$server5] =  $this->mHash($server5);
        $data[$server6] =  $this->mHash($server6);
        $data[$key1] =$this->mHash($key1);
        $data[$key2] =$this->mHash($key2);
        $data2 = $data;
        $data3 = [];
        rsort($data);
        foreach ($data as $key =>$value){
            foreach ($data2 as $key2=>$value2){
                if($value2==$value){
                   $data3[$key2] = $value;
                }
            }
        }
        dd($data3);exit;
        return User::create([
            'name' =>'qudao',
            'email' => 'qudao',
            'password' => bcrypt('qudao123'),
        ]);
        echo 111;
        $date = date('y-m-d',strtotime('+ 3 months -1 day',strtotime('2016-11-29'))) ;
        dd($date);
        $role = Role::findOrFail(1);
        dd($role);
        //
        return view('test');exit;


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
}
