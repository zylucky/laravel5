<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
//use Flc\Alidayu\Client;
//use Flc\Alidayu\App;
//use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
//use Flc\Alidayu\Requests\IRequest;
use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;

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
            $success = $res->Code=="OK"?true:false;
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
        $res = Message::where('id', $id)->update(
            [
                'status'=>2,
                'read_at'=>date('Y-m-d')
            ]);
       return [
           'success'=>$res==1?true:false,
           'msg'=>''
       ];
    }

    /**
     * @param $send_to_id
     * @param $sys
     * 根据发送跟谁查看自己的信息
     */
    public function index($send_to_id,$sys)
    {
        $res = Message::where([
                ['send_to_id','=',$send_to_id],
                ['send_to_sys','=',$sys]
            ])->get();
        return [
            'success'=>true,
            'data'=>$res
        ];


    }
    //发短信

    /**
     * 阿里大鱼
     * @param $phone
     * @param $type
     * @param $yongjin
     */

    public function sendMessage_bak($phone,$type,$yongjin)
    {
        // 配置信息
        $config =
            [
                'app_key'    => '24739810',
                'app_secret' => '6e32fd0efdeec3b419fc43988422e8ac',
                // 'sandbox'    => true,  // 是否为沙箱环境，默认false
            ];


        $templateCode = [
            'SMS_118080024',//test
            ];
        // 使用方法一
        $client = new Client(new App($config));
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

    /**
     * @param $phone
     * @param $type
     * @param $yongjin
     */
    public function sendMessage($phone,$type,$yongjin){
        $config = [
            'accessKeyId'    => 'LTAIqU7BYqEDohQz',
            'accessKeySecret' => 'ubNJux0Vd4D27NW4A66BEj9e4JrmIn',
        ];
        $templateCode = [
            'SMS_117527728',//销售佣金信息待处理通知 0
            'SMS_117527727',//销售佣金信息被驳回通知 1
            'SMS_117512654',//销售佣金信息抄送通知   2
            'SMS_117512653',//销售佣金申请已通过通知 3
            'SMS_117527645',//销售佣金信息待审批通知 4

            'SMS_117512738',//渠道佣金信息待确认通知 5
            'SMS_117522553',//渠道佣金支付通知      6
            'SMS_117522550',//渠道佣金信息被驳回通知 7
            'SMS_117527659',//渠道佣金信息审批通过   8

        ];
        $client  = new Client($config);
        $sendSms = new SendSms;
        $sendSms->setPhoneNumbers($phone);
        $sendSms->setSignName('亮狮网');//阿里云短信测试专用
        $sendSms->setTemplateCode($templateCode[$type]);
        $sendSms->setTemplateParam(['yongjin' => "$yongjin"]);
        $sendSms->setOutId('demo');

         return $client->execute($sendSms);

    }
}
