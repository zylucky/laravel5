<?php
namespace App\http\Controllers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
/**
 *
 */
class UserController extends Controller
{
    public function getlist()
    {
        $name = Input::get('name');
        $rolename = Input::get('rolename');
        $pageSize = Input::get('pageSize');
        $page = Input::get('page');

        $users =  DB::table('users')
            ->leftJoin('role_user','role_user.user_id','=','users.id')
            ->leftJoin('roles','roles.id','=','role_user.role_id')
            ->where("users.name","like","%$name%")
            ->select("users.id","users.name","users.sex","users.email","users.created_at",DB::raw("GROUP_CONCAT(ifnull(roles.name,'')) as role"))
            ->groupBy("users.id","users.name","users.sex","users.email","users.created_at")
            ->having("role","like","%$rolename%")
            ->offset(($page-1)*$pageSize)
            ->limit($pageSize)
            ->get();

        return $data = ['total'=>84,'data'=>$users];

    }
    public function delete()
    {
        $id = Input::get('params')['id'];
        return User::destroy($id);
    }
    public function info()
    {
        $id = Input::get('params')['id'];
        return User::find($id);
    }
    public function addUser(Request $request)
    {
        $input = $request->params;
        $user = new User();
        $user->name = $input['name'];
        $user->password = bcrypt('123456');
        $user->email = $input['email'];
        $user->phone = $input['phone'];
        $user->sex = $input['sex'];
        if($user->save()){
            return [
                'msg'=>'保存成功！',
                'code'=>200
            ];
        }
    }
    public function editUser(Request $request)
    {
        $input = $request->params;
        $id = $input['id'];
        $user = User::find($id);
        $user->name = $input['name'];
        //$user->password = bcrypt('secret');
        $user->email = $input['email'];
        $user->phone = isset($input['phone'])?$input['phone']:'';
        $user->sex = $input['sex'];
        if($user->save()){
            return [
                'msg'=>'保存成功！',
                'code'=>200
            ];
        }
    }
    public function batchRemoveUser(Request $request)
    {
        $ids = $request->params['ids'];
        $arr = explode(',',$ids);
        User::destroy($arr);
    }
    /*
     * 给设置角色
     * */
    public function setRole(Request $request ,$id){
        $input = $request->params;
        //角色全部删除
        DB::table('role_user')->where('user_id' ,'=',$id)->delete();
        $data = [];
        $res = DB::table('roles')->whereIn('name',$input['value'])->select('id')->get();
        foreach ($res as $key=> $value){
            $data[$key]['role_id'] = $value->id;
            $data[$key]['user_id'] = $id;
        }
        //设置
        DB::table('role_user')->insert($data);
    }
    /*
     * 修改密码
     * */
    public function setPassword(Request $request ){
        $input = $request->params;
        // 获取当前用户
        $user = Auth::user();
        $user->password=bcrypt($input['newpassword']);
        $user->save();
    }
    /*
  * 检查密码
  * */
    public function checkPassword(Request $request ){
        $input = $request->params;
        // 获取当前用户
        $user = Auth::user();
        if(Hash::check($input['oldPassword'], $user->password))
        {
             return 1;
        }else{
            return 2;
        }


    }
}