<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class MessageController extends Controller
{
    //
    public function create(Request $request)
    {
        //创建消息
        $message =  Message::create($request->all());
        //发送短信
        if($request->input('is_message')==1){
            $this->sendMessage($request->input('phone'),$request->input('content'),$request->input('type'));
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
    public function sendMessage($phone,$message,$type)
    {
        // 配置信息
        $config = [
            'app_key'    => '*****',
            'app_secret' => '************',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];
        $templateCode = [
            'SMS_15105357',
            'SMS_15105357',
            'SMS_15105357',
            'SMS_15105357',
        ];
        // 使用方法一
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum($phone)
            ->setSmsParam([
                'number' => rand(100000, 999999)
            ])
            ->setSmsFreeSignName('叶子坑')
            ->setSmsTemplateCode($templateCode[$type]);

        $resp = $client->execute($req);

// 返回结果
        print_r($resp);
        print_r($resp->result->model);
    }
}
