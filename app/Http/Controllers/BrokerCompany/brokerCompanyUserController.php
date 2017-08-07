<?php

namespace App\Http\Controllers\BrokerCompany;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class brokerCompanyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示渠道人员列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = Input::get('bk_name');
        $username = Input::get('username');
        $pageSize = Input::get('pageSize');
        $page = Input::get('page');
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $buildingname = Input::get('buildingname');
        $qvdaodengji = Input::get('qvdaodengji');
        $cid = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/person/list', [
            'query' => [
                'page' => $page,
                'size' => $pageSize,
                'compay' => $name,
                'uname' => $username,
                'loupan' => $buildingname,
                'qddj' => $qvdaodengji,
                'sdate' => $startdate,
                'edate' => $enddate,
                'compayid' => $cid,
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
     *保存渠道人员
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        //dd( json_decode($request->params)) ;
        $r = $client->request('POST', '/api/qd/person/add', [
            'json' => $request->params
        ]);
        return $r->getBody();
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
        $response = $client->request('GET', '/api/qd/person/' . $id . '/get', [


            ]
        );
        echo $response->getBody();
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
     *更新渠道人员
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obj = $request->params;

        //dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);

        $r = $client->request('POST', '/api/qd/person/alter', [
            'json' => $obj
        ]);
        return $r->getBody();
    }

    /**
     * Remove the specified resource from storage.
     *删除渠道人员
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return $this->deleteCompany($id);
    }

    public function deleteCompany($id)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/person/{$$}/del');
        return $response->getBody();
    }

    /*
     * 批量删除
     * @param Request $request
     */
    public function batchRemoveBKUser(Request $request)
    {
        $ids = $request->params['ids'];

        $code = '200';
        $arr = explode(',', $ids);
        foreach ($arr as $item) {
            $status = $this->deleteCompany($item);
            if ($status->code != '200') {
                $code = $status->msg;
            }
        }
        return $code;
    }

    public function getbkNameList(Request $request)
    {

        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        $bkName = $request->params['name'];
        $response = $client->request('GET', '/api/qd/compay/list', [
                'query' => [
                    'compay' => $bkName,
                    'zt' => 1,
                ]
            ]
        );
        echo $response->getBody();

    }

    //渠道等级
    public function getQDDJDicList(Request $request)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/comm/person/qddj/list', [
            ]
        );
        echo $response->getBody();
    }

    //停用启用渠道人员状态
    public function changeBrokerCompanyUserStatus(Request $request)
    {
        $obj = $request->params;
        //  dd($obj);
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        if ($obj['status'] == 0) {
            $response = $client->request('GET', '/api/qd/person/' . $obj['id'] . '/start', [
                ]
            );
            echo $response->getBody();
        } else {
            $response = $client->request('GET', '/api/qd/person/' . $obj['id'] . '/stop', [
                ]
            );
            echo $response->getBody();
        }
    }
    //判断联系方式
    public function checkPhone(Request $request)
    {
        $obj = $request->params;
       // dd($obj);
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/check/' . $obj['phone'] .'/'.$obj['id']. '/tel', [
            ]
        );
        echo $response->getBody();
    }
    //判断人员公司与姓名
    public function checkName(Request $request)
    {
        $obj = $request->params;
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/person/checkcompayuname', [
                'query' => [
                    'compayid' => $obj['id'],
                    'uname' => $obj['name']
                ]
            ]
        );
        echo $response->getBody();
    }
}
