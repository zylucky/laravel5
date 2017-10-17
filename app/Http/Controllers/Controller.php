<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    public $base_url;
    public $work_url ;
    public $omc_url ;
    public function __construct(){
        $this->base_url = env('BASE_URL');
        $this->work_url = env('WORK_URL');
        $this->omc_url = env('OMC_URL');
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function objToArray($data){
        //1.获取数据
        $data2 = [];
        foreach ($data as $key=>$value){
            foreach ($value as $k=>$v){
                $data2[$key][] = $v;
            }
        }
        return $data2;
    }
}
