<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;
    use  Notifiable;
    //HasApiTokens,

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','sex','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    
    protected $hidden = [
        'password', 'remember_token',
    ];
}
