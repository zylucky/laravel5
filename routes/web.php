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
Route::resource('role', 'Rbac\RoleController');
Route::resource('purchaseContract','Contract\purchaseContractController');
Route::resource('saleContract','Contract\saleContractController');


Route::post('purchaseContract/review','Contract\purchaseContractController@review');
Route::post('purchaseContract/editTiaoKuan','Contract\purchaseContractController@editTiaoKuan');

Route::resource('brokerCompany','brokerCompany\brokerCompanyController');
Route::resource('brokerCompanyUser','brokerCompany\brokerCompanyUserController');

Route::get('permission/getAll','Rbac\PermissionController@getAll');
Route::get('permission/role/{id}','Rbac\PermissionController@getPermission');
Route::get('permission/update','Rbac\PermissionController@update');

Route::get('permission/list','Rbac\PermissionController@getPermissionList');
Route::post('permission/update/{id}','Rbac\PermissionController@update');
Route::post('brokerCompany/batchRemoveBrokerCompany','brokerCompany\brokerCompanyController@batchRemoveBrokerCompany');
Route::post('brokerCompanyUser/getbkNameList','brokerCompany\brokerCompanyUserController@getbkNameList');
Route::post('brokerCompanyUser/batchRemoveBKUser','brokerCompany\brokerCompanyUserController@batchRemoveBKUser');
Route::post('brokerCompany/checkbkNameList','brokerCompany\brokerCompanyController@checkbkNameList');
Route::post('brokerCompany/getUserById','brokerCompany\brokerCompanyController@getUserById');

Route::post('logout','Auth\LoginController@logout');
Route::post('login','Auth\LoginController@index');

Route::get('user/list','UserController@getlist');
Route::post('user/delete','UserController@delete');
Route::post('user/store','UserController@addUser');
Route::post('user/edit','UserController@editUser');
Route::post('user/role/{id}','UserController@setRole');
Route::post('user/batchRemoveUser','UserController@batchRemoveUser');

Route::get('office/loupanList','Contract\OfficeController@loupanList');
Route::get('office/loudongList','Contract\OfficeController@loudongList');
Route::get('office/fanghaoList','Contract\OfficeController@fanghaoList');
