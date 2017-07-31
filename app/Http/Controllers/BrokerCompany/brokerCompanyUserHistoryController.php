<?php

namespace App\Http\Controllers\BrokerCompany;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class brokerCompanyUserHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示渠道人员跟进列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pageSize = Input::get('pageSize');
        $page= Input::get('page');
        $personid= Input::get('personid');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/gj/person/list',[
            'query' => [
                'page'=>$page,
                'size'=>$pageSize,
                'personid'=>$personid,
            ]
        ]);
        return $response->getBody();
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
     *保存渠道人员跟进记录
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obj=array_merge($request->params,Array('genjinren'=>"张三",'tPersonId'=>1));
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $r = $client->request('POST', '/api/qd/gj/person/add', [
            'json' =>$obj
        ]);
        return  $r ->getBody();
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
     *更新
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obj=$request->params;
        array_pop($obj);
        array_pop($obj);
        //dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);

        $r = $client->request('POST', '/api/qd/person/alter', [
            'json' => $obj
        ]);
        return  $r ->getBody();
    }

    /**
     * Remove the specified resource from storage.
     *删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

}
