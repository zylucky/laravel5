<?php

namespace App\Http\Controllers\Commission;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class receivableController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示应收款列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contractNo = Input::get('contractNo');
        $buildingname= Input::get('buildingname');
        $buildname = Input::get('buildname');
        $roomname = Input::get('roomname');
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $pageSize = Input::get('pageSize');
        $page= Input::get('page');
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/cw/ys/list',[
            'query' => [
                'page'=>$page,
                'size'=>$pageSize,
                'sdate'=>$startdate,
                'edate'=>$enddate,
                'houseno'=>$roomname,
                'htno' =>  $contractNo,
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
     *保存
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


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

        $obj=array_merge($request->params );
        dd($obj);
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
     * Update the specified resource in storage.
     *保存收款记录
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveShouKuan(Request $request)
    {

        $obj=array_merge($request->params );
        dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);

        $r = $client->request('POST', '/api/qd/compay/alter', [
            'json' => $obj
        ]);
        return  $r ->getBody();
    }

    public function destroy($id)
    {
       // dd($id);


    }


}
