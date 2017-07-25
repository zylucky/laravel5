<?php

namespace App\Http\Controllers\Commission;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ChuFangCommissionController  extends Controller
{
    /**
     * Display a listing of the resource.
     *显示出房佣金列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contractNo = Input::get('contractNo');
        $buildingname= Input::get('buildingname');
        $buildname = Input::get('buildname');
        $roomname = Input::get('roomname');
        $ZhuangTai = Input::get('ZhuangTai');
        $startdate=Input::get('startdate');
        $enddate=Input::get('enddate');
        $yjstartdate=Input::get('yjstartdate');
        $yjenddate=Input::get('yjenddate');
        $compayname=Input::get('compayname');
        $pageSize = Input::get('pageSize');
        $page= Input::get('page');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/apply/list',[
                'query' => [
                    'page'=>$page,
                    'size'=>$pageSize,
                    'htno' =>  $contractNo,
                    'lpname'=>$buildingname,
                    'ldname'=>$buildname,
                    'htsdate' =>  $startdate,
                    'htedate'=>$enddate,
                    'yjsdate'=>$yjstartdate,
                    'yjedate' =>  $yjenddate,
                    'houseno' =>  $roomname,
                    'pname' =>  $compayname,
                    'yjstate' =>  $ZhuangTai
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
//        $info = Input::get();
//        if($info) {
//              return [
//                        'message' => '保存成功',
//                        'code' => 200,
//              ];
//        }

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
        dd($id);

    }
    public function  finishFK(Request $request)
    {
        $obj= $request->params ;
        dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/apply/addApplys',[
            'query' =>$obj
        ]);
        return  $response ->getBody();
    }
}
