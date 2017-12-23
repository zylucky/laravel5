<?php

namespace App\Http\Controllers\Api;

use App\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;



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

}
