<?php

namespace App\Http\Controllers\BrokerCompany;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class brokerUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示渠道人员列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $yewuqvyvid=Input::get('yewuqvyvid');
        $yewupianqvid=Input::get('yewupianqvid');
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $qvdaodengji = Input::get('qvdaodengji');
        $username = Input::get('username');
        $pageSize = Input::get('pageSize');
        $page= Input::get('page');
        $tel= Input::get('bk_dianhua');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/qd/ziyou/list',[
            'query' => [
                'page'=>$page,
                'size'=>$pageSize,
                'uname'=>$username,
                'ywqyid' => $yewuqvyvid,
                'ywpqid' => $yewupianqvid,
                'qddj' => $qvdaodengji,
                'sdate' => $startdate,
                'edate' => $enddate,
                'tel'=>$tel,
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      //  dd( $request->params);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);

        $r = $client->request('POST', '/api/qd/ziyou/add', [
            'json' => $request->params
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
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/qd/ziyou/' . $id . '/get', [
            ]
        );
        echo $response->getBody();
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
     *更新渠道人员
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obj=$request->params;
         //dd( json_encode( $request->params, JSON_UNESCAPED_UNICODE));
        //dd($obj);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);

        $r = $client->request('POST', '/api/qd/ziyou/alter', [
            'json' => $obj
        ]);
        return  $r ->getBody();
    }

    /**
     * Remove the specified resource from storage.
     *删除渠道人员
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return $this->deleteCompany($id);
    }

    public  function deleteCompany($id)
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

        $code='200';
        $arr = explode(',',$ids);
        foreach ($arr as $item ){
            $status= $this->deleteCompany($item);
            if($status->code!='200')
            {
                $code=$status->msg;
            }
        }
        return $code;
    }


    //停用启用自由人员状态
    public function changeBrokerCompanyUserStatus(Request $request)
    {
        $obj =$request->params ;

        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        if ($obj['status'] == 0) {
            $response = $client->request('GET', '/api/qd/ziyou/' . $obj['id'] .'/start', [
                ]
            );
            echo $response->getBody();
        } else {
            $response = $client->request('GET', '/api/qd/ziyou/' . $obj['id'] . '/stop', [
                ]
            );
            echo $response->getBody();
        }
    }

}
