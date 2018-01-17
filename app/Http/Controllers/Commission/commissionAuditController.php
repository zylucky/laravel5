<?php

namespace App\Http\Controllers\Commission;

use App\Http\Controllers\Api\MessageController;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Excel;
use Mockery\Exception;

class commissionAuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示佣金列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageSize = Input::get('pageSize');
        $page = Input::get('page');
        $lpname = Input::get('xm');
        $spzt = Input::get('spzt');
        $zfzt = Input::get('zfzt');
        $u = Auth::user();
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/yongjin/list',[
                'query' => [
                    'page'=>$page,
                    'size'=>$pageSize,
                    'userid'=>$u->id,
                    'lpname'=>$lpname,
                    'spzt'=>$spzt,
                    'zfzt'=>$zfzt,
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/yongjin/'.$id.'/get',[
            ]
        );
        return $response->getBody();
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
     *更新
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *删除
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
    /**
     * Update the specified resource in storage.
     *佣金审批
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auditComm(Request $request)
    {

        $user = Auth::user();
        $obj = array_merge($request->params, Array('personid' =>$user->id,'person' =>$user->name,'persontype' =>3));
        //dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);

        $r = $client->request('POST', '/api/qd/yongjin/auditYongJin', [
            'json' => $obj
        ]);
        return $r->getBody();
    }
    /**
     * Update the specified resource in storage.
     *付款
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function  payComm(Request $request)
    {

        $u = Auth::user();
        $obj=    Array(
            'send_from_id'=>$u->id,
            'send_from_name'=>$u->name,
            'send_from_sys'=>'erp',
            'send_to_id'=>$request->params["xsQvdaoid"],
            'send_to_name'=>$request->params["qvdao"],
            'send_to_sys'=>'omc',
            'phone'=>'17611440599',//$request->params["phone"],
            'type'=>6,
            'is_message'=>1,
            'is_web'=>1,
            'yongjin'=>$request->params["yongjin"],
            'sourcemid'=>$request->params["id"],
            'sourcetype'=>'OMC_t_qd_xs_yongjin',
            'title'=> '收款通知',
        );
         DB::connection('mysql3')->update("update t_qd_xs_yongjin SET zfzt=2 where id =".$request->params["id"]);
         $request->request->add($obj);
        $proxy = Request::create(
            '/sendMessage',
            'POST'
        );
        $response = \Route::dispatch($proxy);

        return $response;
    }
}
