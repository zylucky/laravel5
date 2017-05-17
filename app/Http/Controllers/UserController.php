<?php  

namespace App\http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

/**
* 
*/
class UserController extends Controller
{
	/**
	 * show userinfo
	 */
	
	public function show()
	{
		return 'userinfo';
	}
	public function getlist(){
        $name = Input::get('name');
        $pageSize = Input::get('pageSize');
	    return $users =  User::when($name, function ($query) use ($name) {
            return $query->where('name','like',"$name%");
        })->paginate($pageSize);
    }
    public function delete(){
	    $id = Input::get('params')['id'];
	    return User::destroy($id);
    }
    public function info(){
        $id = Input::get('params')['id'];
        return User::find($id);
    }

}