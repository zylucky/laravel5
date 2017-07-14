<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 15:53
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class UserRole extends  Model{
    //设置表名
    const TABLE_NAME="role_user";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;
    public $primaryKey="user_id";
    protected $fillable = [
        'user_id', 'role_id'
    ];
    public function roles ()
    {
        // 多对多的关系（一个用户有多个角色）

        return $this-> belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }
}