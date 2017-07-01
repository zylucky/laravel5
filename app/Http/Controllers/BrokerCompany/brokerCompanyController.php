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
        $response = $client->request('POST', '/api/qd/compay/del',[
                'json' => [
                    'id'=>$id
                ]

            ]
        );
        return $response->getBody();
    }

    public function batchRemoveBrokerCompany(Request $request)
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
    public function getUserById(Request $request)
    {
       $user= DB::table('users')->where('id', $request->params['id'])->first();
        return $user->name;
    }
}
