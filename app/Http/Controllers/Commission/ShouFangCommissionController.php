<?php

namespace App\Http\Controllers\Commission;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class ShouFangCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示收房佣金列表
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
        $personname=Input::get('personname');
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
                'pname' =>  $personname,
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
        //以后用户会从OMC取
        $user=    Array(
            'tEmpId'=>1,
            'empname'=>'张三',
            'empzb'=>null,
        );

        $obj=array_merge($request->params,$user);
       // dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);

        $r = $client->request('POST', '/api/qd/apply/addApplys', [
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
       // dd($id);

    }
    public function  finishSK(Request $request)
    {
        $obj= $request->params ;
       // dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/apply/'.$obj["id"].'/confirm',[
        ]);
        return  $response ->getBody();
    }

}
