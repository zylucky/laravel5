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
Route::post('purchaseContract/review','Contract\purchaseContractController@review');
Route::post('purchaseContract/editTiaoKuan','Contract\purchaseContractController@editTiaoKuan');
Route::get('purchaseContract/confirm','Contract\purchaseContractController@confirm');
Route::resource('purchaseContract','Contract\purchaseContractController');
Route::get('purchaseContract/review','Contract\purchaseContractController@review');
Route::resource('brokerCompany','BrokerCompany\brokerCompanyController');
Route::resource('brokerCompanyUser','BrokerCompany\brokerCompanyUserController');
Route::resource('chuFangCommission','Commission\ChuFangCommissionController');
Route::resource('shouFangCommission','Commission\ShouFangCommissionController');
Route::resource('receivable','Commission\receivableController');
Route::resource('accountsReceivable','Commission\accountsReceivableController');
Route::resource('receivableRecord','Commission\receivableRecordController');
Route::post('receivable/saveShouKuan','Commission\receivableController@saveShouKuan');
Route::resource('payable','Report\payableController');
Route::resource('payavleRecord','Report\payavleRecordController');
Route::resource('paymentRecord','Report\paymentRecordController');



Route::resource('saleContract','Contract\saleContractController');
Route::post('saleContract/sub','Contract\saleContractController@sub');


Route::get('permission/getAll','Rbac\PermissionController@getAll');
Route::get('permission/role/{id}','Rbac\PermissionController@getPermission');
Route::get('permission/update','Rbac\PermissionController@update');

Route::get('permission/list','Rbac\PermissionController@getPermissionList');
Route::post('permission/update/{id}','Rbac\PermissionController@update');
Route::post('brokerCompany/batchRemoveBrokerCompany','BrokerCompany\brokerCompanyController@batchRemoveBrokerCompany');
Route::post('brokerCompanyUser/getbkNameList','BrokerCompany\brokerCompanyUserController@getbkNameList');
Route::post('brokerCompanyUser/batchRemoveBKUser','BrokerCompany\brokerCompanyUserController@batchRemoveBKUser');
Route::post('brokerCompany/checkbkNameList','BrokerCompany\brokerCompanyController@checkbkNameList');
Route::post('brokerCompany/getUserById','BrokerCompany\brokerCompanyController@getUserById');

Route::post('Commission/contractPayType','Commission\CommissionController@selectCommissionPayType');

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

