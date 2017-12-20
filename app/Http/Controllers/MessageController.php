<?php

namespace App\Http\Controllers;

use App\Message;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //
    public function create(Request $request)
    {
        //创建消息
        $message =  Message::create($request->all());
        //发送短信
        if($request->input('is_message')==1){
            $this->sendMessage($request->input('phone'),$request->input('content'));
        }
        return [
            'success'=>true,
            'data'=>$message,
        ];

    }

    /**
     * @param $id
     * 设置已读
     */
    public function read($id)
    {
        //是否已读
        Message::where('id', $id)->update(
            [
                'status'=>1,
                'read_at'=>date('Y-m-d')
                ]);
    }

    /**
     * @param $send_to_id
     * @param $sys
     * 根据发送跟谁查看自己的信息
     */
    public function index($send_to_id,$sys)
    {
        return Message::where([
            ['send_to_id','=',$send_to_id],
            ['send_to_sys','=',$sys]
        ])->get();
    }
    //发短信
    public function sendMessage($phone,$message)
    {
        $client = new  Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://116.62.68.26:8080',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
        $client->post('yhcms/web/qduser/getErpCode.do',[
            'parameters'=>
                [
                    'cookie'=>'',
                    'phone'=>$phone
                ]
        ]);
    }
}
