<?php

namespace App\Http\Controllers\Contract;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class purchaseContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Client([
            // Base URI is used with relative requests /api/contract/list
            'base_uri' => 'http://123.57.48.144:8557',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
        /*$response = $client->get('http://httpbin.org/get');
        $response = $client->delete('http://httpbin.org/delete');
        $response = $client->head('http://httpbin.org/get');
        $response = $client->options('http://httpbin.org/get');
        $response = $client->patch('http://httpbin.org/patch');
        $response = $client->post('http://httpbin.org/post');
        $response = $client->put('http://httpbin.org/put');*/
        $response = $client->request('GET', '/api/contract/list');
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->params;
       // dd($request->params);
        //数据格式化
        $client = new Client([
            'base_uri' => 'http://123.57.48.144:8557',
            'timeout'  => 2.0,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $r = $client->request('POST', '/api/contract/save', [
            'json' => $request->params
        ]);
        //dd($r);
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $info = $request->params;
        dd($info);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
