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
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/qd/compay/list',[
            'query' => [
                'page'=>$page,
                'size'=>$pageSize,
                'compay' =>  $name
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
     *保存渠道公司
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->params);
        $user = Auth::user();
        $obj=array_merge($request->params,Array('tbPersonIdCreate'=>$user->id));
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
     *更新渠道公司
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
     *删除渠道公司
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // dd($id);

        return $this->deleteCompany($id);
    }

    public  function deleteCompany($id)
    {

        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/qd/compay/'.$id.'/del'

        );
        return $response->getBody();
    }


    public function acceptMessage(Request $request)
    {
        $obj= $request->params ;
        dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/qd/apply/addApplys',[
            'query' =>$obj
        ]);
        return  $response ->getBody();
    }
    public function  refuseMessage(Request $request)
    {
        $obj= $request->params ;
        dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/qd/apply/addApplys',[
            'query' =>$obj
        ]);
        return  $response ->getBody();
    }
}
