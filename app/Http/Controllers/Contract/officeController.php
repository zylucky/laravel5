<?php

namespace App\Http\Controllers\Contract;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class officeController extends Controller
{
    //楼盘搜索列表
    public function loupanList(){
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,

        ]);
        $loupan = Input::get('str');
        $response = $client->request('GET', '/api/fangyuan/searchloupan',[
            'query' => ['str' => $loupan]
        ]);
        $obj = json_decode($response->getBody());
        $json = [];
        if($obj->code==200){
            foreach ($obj->data as $key=> $value){
                $json[$value->id] = $value->topic;
            }
            return $json;
        }

    }

    public function loudongList(){
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,

        ]);
        $loupanOmcId = Input::get('loupanOmcId');
        $response = $client->request('GET', '/api/fangyuan/zd',[
            'query' => ['lpid' => $loupanOmcId]
        ]);
        $obj = json_decode($response->getBody());
        $json = [];
        if($obj->code==200){
            foreach ($obj->data as $key=> $value){
                $json[$value->id] = trim($value->zdh,',');
            }
            return $json;
        }else{
            return $obj->msg;
        }
    }

    public function fanghaoList(){
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,

        ]);
        $lpid = Input::get('lpid');
        $zdid = Input::get('zdid');
        $response = $client->request('GET', '/api/fangyuan/fy',[
            'query' => [
                'lpid' => $lpid,
                'zdid' => $zdid,
                ]
        ]);
        $obj = json_decode($response->getBody());
        $json = [];
        if($obj->code==200){
            foreach ($obj->data as $key=> $value){
                $json[$key]['id'] = $value->id;
                $json[$key]['fybh'] = $value->fybh;
                $json[$key]['fjmj'] = $value->fjmj;
            }
            return $json;
        }else{
            echo $obj->msg;
        }
    }
    //销售获取房间号
    public function salefanghaoList(){
        //dd(6666);
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,

        ]);
        $lpid = Input::get('lpid');
        $zdid = Input::get('zdid');
        //dd(111);
        //dd($zdid);
        //dd($lpid);
        $response = $client->request('GET', '/api/fangyuan/xsfy',[
            'query' => [
                'lpid' => $lpid,
                'zdid' => $zdid,
            ]
        ]);
        $obj = json_decode($response->getBody());
        $json = [];
        if($obj->code==200){
            foreach ($obj->data as $key=> $value){
                $json[$key]['id'] = $value->id;
                $json[$key]['fybh'] = $value->fybh;
                $json[$key]['fjmj'] = $value->fjmj;
            }
            return $json;
        }else{
            echo $obj->msg;
        }
    }
    //建立房间的接口
    public function createFanghao()
    {

        $data['lpid'] = Input::get('loupanOmcId');
        $data['zdid'] = Input::get('loudongOmcId');
        $data['fybh'] = Input::get('fanghao');
        //1.建立房间
        $client = new Client([
            'base_uri' => $this->omc_url,
        ]);
        //return $data;
        $response1 = $client->request('POST', '/yhcms/web/zdfyxx/getFyErp.do', [
            'json' => $data
        ]);
        echo $response1->getBody();

    }
    public function loudongRules()
    {

        $data['parameters']['id']= Input::get('loudongOmcId');
        //1.建立房间
        $client = new Client([
            'base_uri' => $this->omc_url,
        ]);
        //return $data;
        $response1 = $client->request('POST', '/yhcms/web/jcsj/getLpZdgz.do', [
            'json' => $data
        ]);
        echo $response1->getBody();

    }
    //获取剩余承租面积的接口
    public function shengyuechengzu()
    {
        $data['id'] = Input::get('id');
        $client = new Client([
            'base_uri' => $this->omc_url,
        ]);
        $response1 = $client->request('POST', '/yhcms/web/jcsj/getByMj.do', [
            'json' => $data
        ]);
        echo $response1->getBody();

    }
    //管家获取合同下的app账号
    public function getAppUserList(){
        $htid = Input::get('htid');
        $page = Input::get('page');
        $size = Input::get('size');
        $httid = Input::get('httid');
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/qduser/list',
            [
                'query' => [
                    'htid' => $htid,
                    'httid' =>  $httid,
                    'page' => $page,
                    'size' => $size,
                ]
            ]
        );
        echo $response->getBody();
    }

    //付款账号的提交
    public function appUserSave(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $param= $request->params ;
        $response = $client->request('POST', '/api/contract/qduser/add', [
            'json' => $param
        ]);
        echo $response->getBody();
    }
    //付款账号的提交
    public function appUserAlter(Request $request){
        //dd(33333);
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $param= $request->params ;
        $response = $client->request('POST', '/api/contract/qduser/alter', [
            'json' => $param
        ]);
        echo $response->getBody();
    }

    public function deleteAppUser(Request $request){
        $param= $request->params ;
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/qduser/delete',[
            'query' => $param
        ]);
        echo $response->getBody();
    }

    public function getUserListByPhone(){
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,

        ]);
        $phone = Input::get('phone');
       // dd($phone);die;
        $response = $client->request('GET', '/api/contract/qduser/getUserByPhone',[
            'query' => [
                'phone' => $phone,
            ]
        ]);
        $obj = json_decode($response->getBody());
        $json = [];
        if($obj->code==200){
            foreach ($obj->data as $key=> $value){
                $json[$key]['id'] = $value->id;
                $json[$key]['phone'] = $value->phone;
                $json[$key]['name'] = $value->name;
                $json[$key]['typeid'] = $value->typeid;
            }
            return $json;
        }else{
            echo $obj->msg;
        }
    }
}

