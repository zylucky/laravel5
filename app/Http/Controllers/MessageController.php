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
            $res = $this->sendMessage(
                $request->input('phone'),
                $request->input('type'),
                $request->input('yongjin')
            );
            $success = isset($res->err_code)?false:true;
        }else{
            $res = $this->send($message->id);
            $success = $res==1?true:false;
        }
        return [
            'success'=>$success,
            'msg'=>$res
        ];
    }
    public function send($id){
       return Message::where('id',$id)->update(['status'=>1]);
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

    /**
     * @param $phone
     * @param $type
     * @param $yongjin
     */
    public function sendMessage($phone,$type,$yongjin)
    {
        $success = true;
        // 配置信息
        $configs = [
            [
                'app_key'    => '24739810',
                'app_secret' => '6e32fd0efdeec3b419fc43988422e8ac',
                // 'sandbox'    => true,  // 是否为沙箱环境，默认false
            ]
        ];

        $templateCode = ['SMS_118080024'];
        // 使用方法一
        $client = new Client(new App($configs[$type]));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum($phone)
            ->setSmsParam([
                'yongjin' => $yongjin
            ])
            ->setSmsFreeSignName('幼狮')
            ->setSmsTemplateCode($templateCode[$type]);
        $resp = $client->execute($req);
        return $resp;
    }
}
