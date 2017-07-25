<?php

namespace App\Http\Controllers;

use App\models\Role;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Qiniu\Auth;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = date('y-m-d',strtotime('+ 3 months -1 day',strtotime('2016-11-29'))) ;
        dd($date);
        $role = Role::findOrFail(1);
        dd($role);
        //
        return view('test');exit;


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return 1;
        $fp = fopen($_FILES["file"]["tmp_name"],"rb");
        $image = fread($fp,$_FILES["file"]["size"]);
        $image = base64_encode($image);
        $data = [
            'id'=>$_POST['id'],
            'type'=>$_GET['type'],
            'image'=>$image,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
