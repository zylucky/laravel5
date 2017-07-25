<?php

namespace App\Http\Controllers\BrokerCompany;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class brokerCompanyHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示渠道跟进列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageSize = Input::get('pageSize');
        $page= Input::get('page');
        $companyId=Input::get('id');

        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/gj/compay/list',[
            'query' => [
                'page'=>$page,
                'size'=>$pageSize,
                'compayid'=>1,
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
     *保存渠道跟进记录
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      // dd( $request->params);
        //"genjinjindo":"一","genjindate":1500364339000,"genjinren":"张三","tPersonId":1,
        $obj=array_merge($request->params,Array('genjinren'=>"张三",'tPersonId'=>1));
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);

        $r = $client->request('POST', '/api/qd/gj/compay/add', [
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

        return $this->deleteCompany($id);
    }


}
