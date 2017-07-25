<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    //public $base_url = 'http://192.168.0.163:8557';这个文件是接口的IP地址的文件
    public $base_url = 'http://121.196.195.129:8557';//这个是线上数据库的IP地址

    public $work_url = 'http://121.196.195.129:6316';//这个是测试服务器的ip地址
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
