<?php

namespace App\Http\Controllers\contract;

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
            echo  $obj;
        }
    }

}
