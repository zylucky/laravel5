<?php

namespace App\Http\Controllers\Contract;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class decorationController extends Controller
{
    //工程合同列表页
    public function index(){
        $pn = Input::get('pn');
        $cnt = Input::get('cnt');
        $status = Input::get('status');
        $name = Input::get('name');
        if(!$pn){
            $pn = 1;
        }
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/gc/list',[
            'query'=>[
                'pn'=>$pn,
                'cnt'=>$cnt,
                'status'=>$status,
                'name'=>$name,
            ]
        ]);
        echo $response->getBody();
    }
    //合同详情
    public function show(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/gc/',[
            'query'=>[
                'id'=>$id,
            ]
        ]);
        echo $response->getBody();

    }
    //修改
    public function submit(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $data = $request->params;
        $response = $client->request('POST', '/api/contract/gc/modify', [
            'json' => $data,
        ]);
        echo $response->getBody();
    }
    //保存
    public function store(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $data = $request->params;
        $response = $client->request('POST', '/api/contract/gc/submit', [
            'json' => $data,
        ]);
        echo $response->getBody();
    }
    //改变合同状态
    public function status(){
        $id = Input::get('id');
        $status = Input::get('status');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        switch ($status)
        {
            case 1:
                $requestUrl = 'api/contract/gc/'.$id.'/confrim';
            break;
            case 2:
                $requestUrl = '/api/contract/gc/'.$id.'/finish';
            break;
            default:
                ;
        }
        $response = $client->request('GET', $requestUrl,[
            'query'=>[
                'id'=>$id,
            ]
        ]);
        echo $response->getBody();
    }

}
