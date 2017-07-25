<?php

namespace App\Http\Controllers\Message;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class messageController  extends Controller
{
    /**
     * Display a listing of the resource.
     *显示消息通知列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = Input::get('bk_name');
        $pageSize = Input::get('pageSize');
        $page= Input::get('page');
        $client = new Client ([
            'base_uri' =>$this->work_url,

        ]);
        $response = $client->request('POST', '/api/wf/gettasksto',[
            'json' => [
                'data'=>14,
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
       // dd($request->params);

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




    public function acceptMessage(Request $request)
    {
        $obj= [
            'cmd'=>10004,
            'data'=>$request->params,
            'operatorId'=>14,
            'operatorName'=>'梁旭',
        ];
        //dd($obj);
        $client = new Client ([
            'base_uri' =>$this->work_url,

        ]);
        $response = $client->request('POST', '/api/wf/dotask',[
            'json' =>$obj
        ]);
        return  $response ->getBody();
    }
    public function  refuseMessage(Request $request)
    {
        $obj= [
            'cmd'=>10005,
            'data'=>$request->params,
            'operatorId'=>14,
            'operatorName'=>'梁旭',
        ];
       // dd($obj);
        $client = new Client ([
            'base_uri' =>$this->work_url,

        ]);
        $response = $client->request('POST', '/api/wf/dotask',[
            'json' =>$obj
        ]);
        return  $response ->getBody();
    }
}
