<?php

namespace App\Http\Controllers\Rbac;

use App\models\Permission;
use App\models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {

    }
    //获取系统权限列表
    public function getAll()
    {
        $permissions = Permission::All(['id','display_name as label','parent_id'])->toArray() ;
        return $this->make_tree($permissions);

    }
    //更改角色权限
    public function update(Request $request,$id)
    {

        //删除该角色的所有原权限
        DB::table('permission_role')->where('role_id', '=', $id)->delete();
        $input = $request->params;
        $lists = $input['permissions'];
        $data = [];
        foreach ($lists as $key => $list){
            $data[$key]['permission_id']=$list;
            $data[$key]['role_id']=$id;
        }
        //重新插入数据
        DB::table('permission_role')->insert($data);

    }

    /*
     *  获取当前用户的权限列表
     * */
    public function getPermissionList()
    {
        // 获取当前用户
        $user = Auth::user();
        //获取当前用户的角色
        $roles = $user->roles;
        //获取所有的权限
        $permissionIds = [];
        foreach ($roles as $role){
            foreach($role->permissions->toArray() as $permission ){
                $permissionIds[] = $permission['id'];
            }
        }
        $permissionIds = array_unique($permissionIds);
        $permissions = DB::table('permissions')
            ->whereIn('id', $permissionIds)
            ->select('parent_id')
            ->get();
        $newArr = [];
        foreach ($permissions as $key=>$value){
            $newArr[]= $value->parent_id;
        }
        $permissions2 = DB::table('permissions')
            ->whereIn('id', $newArr)
            ->select('parent_id')
            ->get();
        foreach ($permissions2 as $key=>$value){
            $newArr[]= $value->parent_id;
        }
        $lists= array_merge($newArr,$permissionIds);
        $lists = array_unique($lists);
        foreach ($lists as $key=>$value){
            if($value==0){
                unset($lists[$key]);
            }
        }
        $permissions = [];
        $dbs = DB::table('permissions')
            ->whereIn('id', $lists)
            ->select('fun_key')
            ->get();
        foreach ($dbs as $value){
            $permissions[]=$value->fun_key;
        }
        return $permissions;
    }
    /*
     *  获取当前用户的权限列表
     * */
    public function getPermission($id)
    {
        //获取当前角色
        $role = Role::find($id);
        //获取所有的权限
        $permissions = [];
        foreach($role->permissions->toArray() as $permission ){
            $permissions[] = $permission['id'];
        }
        return $permissions;
    }


    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pk 自增字段（栏目id）
     * @param string $pid parent标记字段
     * @return array
     * @author dqs <1696232133@qq.com>
     */
    private function make_tree($list,$pk='id',$pid='parent_id',$child='children',$root=0){
        $tree=array();
        $packData=array();
        foreach ($list as  $data) {
            $packData[$data[$pk]] = $data;
        }
        foreach ($packData as $key =>$val){
            if($val[$pid]==$root){//代表跟节点
                $tree[]=& $packData[$key];
            }else{
                //找到其父类
                $packData[$val[$pid]][$child][]=& $packData[$key];
            }
        }
        return $tree;
    }
}
