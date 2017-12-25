<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'yz_users';
    protected $fillable = ['phone','password','rand','access_time','expire_time'];
    protected $hidden = ['password','rand','access_token'];
}
