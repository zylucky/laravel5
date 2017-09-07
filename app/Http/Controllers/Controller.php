<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    //public $base_url = 'http://121.196.195.129:8557';
    public $base_url = 'http://192.168.0.222:8557';
    public $work_url = 'http://121.196.195.129:6316';
    //public $work_url = 'http://192.168.0.222:6316';
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
