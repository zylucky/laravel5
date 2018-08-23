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
       return $this->createMessage($request->all());
    }

    /**
     * 创建
     * @param $params
     * @return array
     */
    public function createMessage($params){
        //创建消息
        $message =  Message::create($params);
        $param=array();
        //发送短信
        if(isset($params['yongjin']))
        {
            array_push($param,$params['yongjin']) ;
        }
        if(isset($params['qianyueren']))
        {
          array_push($param,$params['qianyueren']) ;
        }
        if(isset($params['date']))
        {
            array_push($param,$params['date']) ;
        }
        if(isset($params['loupan']))
        {
            array_push($param,$params['loupan']) ;
        }
        if(isset($params['httype']))
        {
            array_push($param,$params['httype']) ;
        }
        if($params['is_message']==1){
            $res = $this->sendMessage($params['phone'], $params['type'], $param);
            $success = $res->Code=="OK"?true:false;
        }elseif($params['is_web']==1){
            $res = $this->send($message->id);
            $success = $res==1?true:false;
        }
        return [
            'success'=>$success,
            'msg'=>$res
        ];
    }
    //发送
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

    /**
     * @param $phone
     * @param $type
     * @param array ...$params
     * @return mixed
     */
    public function sendMessage($phone,$type,$params){
        $config  = config('message.config');
        $templateCodesParams = config('message.templateCodesParams');//获取配置的编码和对应的模板参数
        $templateCodes = array_keys($templateCodesParams);//获取配置数组的所有编码

        $currentCode = $templateCodes[$type];//当前模版编码
        $currentCodeParam = $templateCodesParams[$currentCode];//当前模板编码和对应的参数
        $templateParam = [];
        if(count($params)>0&&count($currentCodeParam)>0){
            foreach ($params as $key => $param){
                $templateParam[$currentCodeParam[$key]] = $param;
            }
           // print_r($templateParam);die;
        }
        $client  = new Client($config);
        $sendSms = new SendSms;
        $sendSms->setPhoneNumbers($phone);
        //$sendSms->setPhoneNumbers('17611480828');
        $sendSms->setSignName('亮狮网');//阿里云短信测试专用
        $sendSms->setTemplateCode($templateCodes[$type]);
        $sendSms->setTemplateParam($templateParam);
        $sendSms->setOutId('demo');
       // print_r($client->execute($sendSms));die;
        return $client->execute($sendSms);

    }
}
