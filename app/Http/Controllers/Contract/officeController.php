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
        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        $lpid = Input::get('lpid');
        $zdid = Input::get('zdid');
        //dd(111);
        //dd($zdid);
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

}
