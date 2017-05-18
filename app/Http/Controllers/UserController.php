<?php  

namespace App\http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
* 
*/
class UserController extends Controller
{

	public function getlist()
    {
        $name = Input::get('name');
        $pageSize = Input::get('pageSize');
	    return $users =  User::when($name, function ($query) use ($name) {
            return $query->where('name','like',"$name%");
        })->paginate($pageSize);
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
        $user->password = bcrypt('secret');
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
        $user->phone = $input['phone'];
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

}