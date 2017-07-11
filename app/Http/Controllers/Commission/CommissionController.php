<?php

namespace App\Http\Controllers\Commission;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *选择佣金付款类型
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function selectCommissionPayType(Request $request)
    {
        $obj=array_merge($request->params,Array('tHetongType'=>'0'));

        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);

        $r = $client->request('POST', '/api/qd/apply/add', [
            'json' => $obj
        ]);

        return  $r ->getBody();

    }

}
