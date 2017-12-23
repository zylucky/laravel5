<?php
/**
 * Created by PhpStorm.
 * User: liyuequn
 * Date: 2017/12/22
 * Time: 下午2:17
 */
namespace App\Api\Helpers\Api;
use App\Owner;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Response;

trait ApiResponse
{
    /**
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {

        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respond($data, $header = [])
    {

        return Response::json($data,$this->getStatusCode(),$header);
    }

    /**
     * @param $status
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function status($status, array $data, $code = null){

        if ($code){
            $this->setStatusCode($code);
        }

        $status = [
            'status' => $status,
            'code' => $this->statusCode
        ];

        $data = array_merge($status,$data);
        return $this->respond($data);

    }

    /**
     * @param $message
     * @param int $code
     * @param string $status
     * @return mixed
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'error'){

        return $this->setStatusCode($code)->message($message,$status);
    }

    /**
     * @param $message
     * @param string $status
     * @return mixed
     */
    public function message($message, $status = "success"){

        return $this->status($status,[
            'message' => $message
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function internalError($message = "Internal Error!"){

        return $this->failed($message,FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function created($message = "created")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)
            ->message($message);

    }

    /**
     * @param $data
     * @param string $status
     * @return mixed
     */
    public function success($data, $status = "success"){

        return $this->status($status,compact('data'));
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        return $this->failed($message,Foundationresponse::HTTP_NOT_FOUND);
    }

    /**
     * @param $rand
     * @return string
     */
    public function createAccessToken($owner)
    {
        $time = time();
        $access_token = bcrypt($owner->phone.$owner->rand.$time);
        Owner::where('phone',$owner->phone)->update(
            ['access_token'=>$access_token,'expire_time'=>date('Y-m-d H:i:s',$time)]
        );
        return $access_token;
    }

    /**
     * @param $request
     * @return mixed 验证是否正确
     */
    public function AccessToken($request)
    {
        $access_token = $request->header('access_token');
        $owner = Owner::where('access_token',$access_token)->first();
        if($owner){
            if(time()-strtotime($owner->expire_time)>7200){
                return $this->failed('access_token已过期，请重新登录',401,'Authorization invalid');
            }
        }else{
            return $this->failed('无权限',401,'Authorization invalid');
        }
    }

}