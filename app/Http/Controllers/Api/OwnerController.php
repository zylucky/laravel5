<?php

namespace App\Http\Controllers\Api;

use App\Owner;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Mockery\Exception;


class OwnerController extends ApiController
{

    /**
     * @param Request $request
     * @return string用户注册
     */
    public function create(Request $request)
    {
        $password = $request->input('password');
        $confirm = $request->input('confirm');
        $verificationCode = $request->input('verificationCode');
        $phone = $request->input('phone');
        $type = $request->input('type');
        $rand = str_random(10);
        if( $password!=$confirm){
            return '密码不一致';
        }
        if($verificationCode != Redis::get($phone.'_code')){
            return '验证码错误';
        }
        $res = Owner::where('phone',$phone)->first();
        if($res){
            return $this->failed('用户已存在');
        }else{
            $owner = Owner::create([
                'phone'=>$phone,
                'type' =>$type,
                'password'=>md5($password.$rand),
                'rand'=>$rand,
            ]);
            return $this->success($owner);
        }


    }

    //用户登录
    public function login(Request $request)
    {
        $password = $request->input('password');
        $phone = $request->input('phone');
        $verificationCode = $request->input('verificationCode');
        $mark = false;
        if(!isset($phone)){
            return '手机号为必须';
        }
        $owner = Owner::where('phone',$phone)->first();

        if(isset($password)){
            if($owner->password!=md5($password.$owner->rand)){
                return $this->failed('密码错误',400,'error');
            }else{
                $mark = true;
            }
        }elseif(isset($verificationCode)){
            if($verificationCode != Redis::get($phone.'_code')){
                return '验证码错误';
            }else{
                $mark = true;
            }
        }else {
            return '密码或验证码不能为空';
        }
        //发送access_token
        if($mark){
            $access_token = $this->createAccessToken($owner);
            return $this->success(['owner'=>$owner,'access_token'=>$access_token]);
        }

    }

    /**
     * @param $id
     * @return mixed获取用户信息
     */
    public function index($id)
    {
        $owner = Owner::find($id);
        return $this->success($owner);
    }

    /**
     *  发送验证码
     */
    public function sendVerificationCode($phone)
    {
        $verificationCode = rand(100000,999999);
        $message  = new MessageController();
        $res = $message->sendMessage($phone,5,$verificationCode);
        if(!isset($res->err_code)){
            Redis::set($phone.'_code',$verificationCode);
            return $this->success($verificationCode);
        }else{
            return $this->failed('发送失败');
        }
    }

    /**
     * @param Request $request
     * 验证码是否正确 此时处于为登录的状态
     */
    public function verifyCode(Request $request)
    {
        $phone = $request->input('phone');
        $verificationCode = $request->input('verificationCode');
        if(Redis::get($phone.'_code')!=$verificationCode)
        {
            return $this->failed('验证码错误');
        }else{
            $owner = Owner::where('phone',$phone)->first();
            $access_token = $this->createAccessToken($owner);
            return $this->success(['owner'=>$owner,'access_token'=>$access_token]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 重置密码
     */
    public function resetPassword(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        $confirm = $request->input('confirm');
        if($password==$confirm){
            if($this->updatePassword($phone,$password))
            {
                return $this->message('密码已经重置');
            }
        }else{
            return $this->failed('密码不一致',400,'error');
        }

    }

    /**
     * 修改密码
     */
    public function editPassword(Request $request)
    {
        $oldPassword = $request->input('oldPassword');
        $phone = $request->input('phone');
        $password = $request->input('password');
        $confirm = $request->input('confirm');
        $owner = Owner::where('phone',$phone)->first();
        if($password!=$confirm){
            return $this->failed('密码不一致',400,'error');
        }elseif($owner->password!=md5($oldPassword.$owner->rand)){
            return $this->failed('旧密码错误',400,'error');
        }else{
            if($this->UpdatePassword($phone,$password))
            {
                return $this->message('密码已经重置');
            }
        }

    }

    public function updatePassword($phone,$password)
    {
        $rand = str_random(10);
        $res = Owner::where('phone',$phone)->update(['password'=>md5($password.$rand),'rand'=>$rand]);
        return $res;
    }

    /**
     * @param Request $request
     * @return mixed|string
     */
    public function createOwner(Request $request)
    {
        $admin = Owner::where('phone',18511909124)->first();
        if($request->header('access_token')!=$admin->access_token)
        {
            return $this->failed('Authorization invalid',401);
        }
        $password = $request->input('password');
        $phone = $request->input('phone');
        $type = $request->input('type');
        $rand = str_random(10);
        $res = Owner::where('phone',$phone)->first();
        if($res){
            return $this->failed('用户已存在');
        }else{
            try{
                DB::beginTransaction();
                $owner = Owner::create([
                    'phone'=>$phone,
                    'type'=>$type,
                    'password'=>md5($password.$rand),
                    'rand'=>$rand,
                ]);
                foreach ($request->input('fy_id') as $key => $value)
                {
                    DB::connection('mysql3')->insert("insert into yz_fy  (yz_id,fy_id) VALUE ($owner->id,$value)");
                }
                DB::commit();
                return $this->success($owner);

            }catch (Exception $exception){
                DB::rollBack();
            }

        }
    }
    /*
     * 收购前，根据业主获取到的房源信息
     */
    public function yzfyInfo($yz_id)
    {
        $client = new Client([
            'base_uri' => $this->omc_url,
        ]);
        $yzfys = DB::connection('mysql3')->select("select * from yz_fy where yz_id = $yz_id");

        foreach ($yzfys as $yzfy)
        {
            $response = $client->post('/yhcms/web/jcsj/getErpFy.do',[
                'json' => ['fyid'=>$yzfy->fy_id]
            ]);
           $res[] = json_decode($response->getBody())->data;
           //在erp中查找是否已经收购，收购的信息和销售的信息
            $purchaseInfo = DB::connection('mysql2')->select("
            select * from t_shoufang_office office INNER  JOIN t_shoufanghetong ht ON office.HetongId = ht.id where omc_id = $yzfy->fy_id
            
            ");
            if($purchaseInfo)
            {
                //已经收购  委托时间（收购时间）、到期时间，租户信息（租户名称、起租时间、到期时间、所属行业）
                $start_time = $purchaseInfo->;
            }
            $saleInfo = DB::connection('mysql2')->select("select * from t_xs_office where omc_id = $yzfy->fy_id");

        }


        return $this->success($res);

    }
}
