<?php

namespace App\Http\Controllers\Report;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class financeReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示实收款列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fkyh = Input::get('fkyh');
        $fkzh = Input::get('fkzh');
        $zt = Input::get('zt');
        $pageSize = Input::get('pageSize');
        $page = Input::get('page');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/cw/ys/caiwulist', [
                'query' => [
                    'page' => $page,
                    'size' => $pageSize,
                    'fkyh' =>$fkyh,
                    'fkzh' =>$fkzh,
                    'zt'=>$zt,
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
     *认领保存
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obj =$request->params;
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $r = $client->request('POST', '/api/cw/ys/caiwurenling', [
            'json' => $obj
        ]);
        echo  $r->getBody();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *更新应收款记录
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $obj = array_merge($request->params);
        dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);

        $r = $client->request('POST', '/api/qd/compay/alter', [
            'json' => $obj
        ]);
        return $r->getBody();
    }

    /**
     * Update the specified resource in storage.
     *保存收款记录
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveShouKuan(Request $request)
    {

        $obj = array_merge($request->params);
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $r = $client->request('POST', '/api/cw/ys/caiwuadd', [
            'json' => $obj
        ]);
        return $r->getBody();
    }

    public function destroy($id)
    {
        // dd($id);


    }


}
