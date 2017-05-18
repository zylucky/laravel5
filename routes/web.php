<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function (){
    return view('home');
});
Route::resource('test', 'TestController');


Route::post('logout','Auth\LoginController@logout');
Route::post('login','Auth\LoginController@index');

Route::get('user/list','UserController@getlist');
Route::post('user/delete','UserController@delete');
Route::post('user/store','UserController@addUser');
Route::post('user/edit','UserController@editUser');
Route::post('user/batchRemoveUser','UserController@batchRemoveUser');