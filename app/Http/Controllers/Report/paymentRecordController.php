<?php

namespace App\Http\Controllers\Report;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class paymentRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示应收款记录
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contractNo = Input::get('contractNo');
        $buildingname= Input::get('buildingname');
        $buildname = Input::get('buildname');
        $roomname = Input::get('roomname');
        $ZhuangTai = Input::get('ZhuangTai');
        $pageSize = Input::get('pageSize');
        $page= Input::get('page');
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/qd/compay/list',[
            'query' => [
                'page'=>$page,
                'size'=>$pageSize,
                'compay' =>  $contractNo
                ]

       ]
        );
        echo $response->getBody();

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
     *保存应收款记录
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->params);
        $obj=array_merge($request->params );
        //dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);

        $r = $client->request('POST', '/api/qd/compay/add', [
            'json' => $obj
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
     *更新应收款记录
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $obj=array_merge($request->params,Array('tQdCompayId'=>$id));
        //dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);

        $r = $client->request('POST', '/api/qd/compay/alter', [
            'json' => $obj
        ]);
        return  $r ->getBody();
    }

    /**
     * Remove the specified resource from storage.
     *删除应收款记录
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       dd($id);

        return $this->deleteCompany($id);
    }

    public  function deleteCompany($id)
    {

        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('POST', '/api/qd/compay/del',[
                'json' => [
                    'id'=>$id
                ]

            ]
        );
        return $response->getBody();
    }

}
