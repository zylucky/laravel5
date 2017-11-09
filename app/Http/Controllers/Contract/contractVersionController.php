<?php

namespace App\Http\Controllers\Contract;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class contractVersionController extends Controller
{
    //模板列表页
    public function index(){
        $pn = Input::get('pn');
        $cnt = Input::get('cnt');
        $status = Input::get('status');
        $category = Input::get('category');
        if(!$pn){
            $pn = 1;
        }
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/muban/list',[
            'query'=>[
                'pn'=>$pn,
                'cnt'=>$cnt,
                'status'=>$status,
                'hetongType'=>$category,
            ]
        ]);
        echo $response->getBody();
    }
    //启用与禁用模板
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
                $requestUrl = 'api/contract/muban/'.$id.'/enable';
                break;
            case 0:
                $requestUrl = 'api/contract/muban/'.$id.'/disable';
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
