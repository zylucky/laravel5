<?php

namespace App\Http\Controllers\BrokerCompany;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class brokerCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *显示渠道公司列表
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
        echo $response->getBody();
    }

    public function batchRemoveBrokerCompany(Request $request)
    {
        $ids = $request->params['ids'];
        $code='200';
        $arr = explode(',',$ids);

        foreach ($arr as $item ){
           // dd($item);
          $status= $this->deleteCompany($item);
           if($status->code!='200')
           {
               $code=$status->msg;
           }
        }
        return $code;
       // destroy($arr);
    }
    public function checkbkNameList(Request $request)
    {
       // dd($request->params['name']);
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $bkName =$request->params['name'];

        $response = $client->request('GET', '/api/qd/compay/check',[
                'query' => [
                    'compay' =>  $bkName
                ]

            ]
        );
        //dd($response->getBody());


        echo $response->getBody();

    }
    //公司经营属性
    public function getGSSXDicList(Request $request)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/qd/comm/compay/jysx/list',[
            ]
        );
        echo $response->getBody();
    }
    //服务对象
    public function getFWDXDicList(Request $request)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/qd/comm/compay/fwdx/list',[
            ]
        );
        echo $response->getBody();
    }
    //业务区域
    public function getYWQYDicList(Request $request)
    {
        $parentid =$request->params['parentid'];
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/area/searchbusiness',[
                'query' => [
                    'parentid' =>  $parentid
                ]
            ]
        );
        echo $response->getBody();
    }
    //行政区域
    public function getXZQYDicList(Request $request)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/area/searchcity',[
            ]
        );
        echo $response->getBody();
    }
    //根据行政区域获取街道
    public function getJDDicList(Request $request)
    {
        $code =$request->params['code'];

        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/area/searchcity',[
                'query' => [
                    'code' =>  $code
                ] ]
        );
        echo $response->getBody();
    }

    //停用启用渠道公司状态
    public function changeBrokerCompanyStatus(Request $request)
    {
        $obj =$request->params ;

        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('POST', '/api/area/searchcity',[
                'json' => $obj]
        );
        echo $response->getBody();
    }

}
