<?php

namespace App\Http\Controllers\Contract;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class saleContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //出房合同的列表页的数据
    public function index(){
        $pn = Input::get('pn');
        $cnt = Input::get('cnt');
        if(!$pn){
            $pn = 1;
        }
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/xs/list',[
            'query'=>[
                'pn'=>$pn,
                'cnt'=>$cnt,
            ]
        ]);
        echo $response->getBody();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //出房合同点新增后保存数据的方法
    public function store(Request $request)
    {
        //return $request->params;
        //数据格式化
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/xs/save', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }


    /**
     * Display the specified resource.
     * 根据合同ID获取合同的信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //出房合同点编辑后显示数据的方法
    public function show($id)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/xs/save'.$id);
        echo $response->getBody();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*edit --->编辑*/
    //在这里是提交那个按钮的处理
    public function edit($id)
    {
        dd(2222);
        /*$client = new Client([
            'base_uri' => $this->base_url,
            'timeout' => 2.0,
        ]);
        $response = $client->request('GET','/api/contract/xs/'.$id.'/submit');
        echo $response->getBody();*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //出房合同点击编辑后保存的方法
    public function update(Request $request, $id)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/xs/update'.$id);
        echo $response->getBody();
        /*$info = $request->params;
        dd($info);*/
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

    //删除
    public function delete(){
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/xs/delete', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }



}