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
//收房合同分组
Route::group(['prefix' => 'purchaseContract'], function () {
    Route::post('review','Contract\purchaseContractController@review');
    Route::post('weiYueInfo','Contract\purchaseContractController@weiYueInfo');
    Route::post('weiYueSave','Contract\purchaseContractController@weiYueSave');
    Route::get('optimize','Contract\purchaseContractController@getOptimize');
    Route::get('approving','Contract\purchaseContractController@approving');
    Route::post('editTiaoKuan','Contract\purchaseContractController@editTiaoKuan');
    Route::get('confirm','Contract\purchaseContractController@confirm');
    Route::get('confirming','Contract\purchaseContractController@confirming');
    Route::get('violating','Contract\purchaseContractController@violating');
    Route::get('terminated','Contract\purchaseContractController@terminated');
    Route::get('releasing','Contract\purchaseContractController@releasing');
    Route::get('released','Contract\purchaseContractController@released');
});
Route::resource('purchaseContract','Contract\purchaseContractController');
Route::group(['prefix' => 'decoration'], function () {
    Route::get('index','Contract\decorationController@index');
    Route::get('show','Contract\decorationController@show');
    Route::post('submit','Contract\decorationController@submit');
    Route::post('store','Contract\decorationController@store');
    Route::get('status','Contract\decorationController@status');
});


//Route::get('purchaseContract/review','Contract\purchaseContractController@review');
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
Route::post('shouFangCommission/finishSK','Commission\ShouFangCommissionController@finishSK');

//消息列表
Route::resource('message','Message\messageController');

Route::post('message/acceptMessage','Message\messageController@acceptMessage');
Route::post('message/refuseMessage','Message\messageController@refuseMessage');

//Route::post('saleContract/sub','Contract\saleContractController@sub');
Route::post('saleContract/submit','Contract\saleContractController@submit');
Route::get('saleContract/jieyue','Contract\saleContractController@jieyue');
Route::get('saleContract/approving','Contract\saleContractController@approving');
Route::get('saleContract/confirm','Contract\saleContractController@confirm');
Route::get('saleContract/confirmed','Contract\saleContractController@confirmed');
Route::get('saleContract/violating','Contract\saleContractController@violating');
Route::get('saleContract/terminated','Contract\saleContractController@terminated');
Route::get('saleContract/releasing','Contract\saleContractController@releasing');
Route::get('saleContract/released','Contract\saleContractController@released');
Route::post('saleContract/review','Contract\saleContractController@review');
Route::post('saleContract/jieyuesave','Contract\saleContractController@jieyuesave');
Route::get('saleContract/jieyuelist','Contract\saleContractController@jieyuelist');

Route::resource('saleContract','Contract\saleContractController');//这要放到confirm方法的后面，因为放到confirm的前面会把confirm的这个路径和它的这个路由混要了

//权限
Route::group(['prefix' => 'permission'], function () {
    Route::get('getAll','Rbac\PermissionController@getAll');
    Route::get('role/{id}','Rbac\PermissionController@getPermission');
    Route::get('update','Rbac\PermissionController@update');
    Route::get('list','Rbac\PermissionController@getPermissionList');
    Route::post('update/{id}','Rbac\PermissionController@update');
});
//消息
Route::group(['prefix' => 'message'], function () {
    Route::post('acceptMessage','Message\messageController@acceptMessage');
    Route::post('refuseMessage','Message\messageController@refuseMessage');
});
//渠道公司
Route::group(['prefix' => 'brokerCompany'], function () {
    Route::post('checkbkNameList','BrokerCompany\brokerCompanyController@checkbkNameList');

});
//渠道公司人员
Route::group(['prefix' => 'brokerCompanyUser'], function () {
    Route::post('getbkNameList','BrokerCompany\brokerCompanyUserController@getbkNameList');
});
Route::resource('brokerCompanyHistory','BrokerCompany\brokerCompanyHistoryController');
Route::resource('brokerCompanyUserHistory','BrokerCompany\brokerCompanyUserHistoryController');

Route::post('Commission/contractPayType','Commission\CommissionController@selectCommissionPayType');

Route::post('logout','Auth\LoginController@logout');
Route::post('login','Auth\LoginController@index');

//用户
Route::group(['prefix' => 'user'], function () {
    Route::get('list','UserController@getlist');
    Route::post('delete','UserController@delete');
    Route::post('store','UserController@addUser');
    Route::post('edit','UserController@editUser');
    Route::post('role/{id}','UserController@setRole');
    Route::post('batchRemoveUser','UserController@batchRemoveUser');
});

//合同房源
Route::group(['prefix' => 'office'], function () {
    Route::get('loupanList','Contract\officeController@loupanList');
    Route::get('loudongList','Contract\officeController@loudongList');
    Route::get('fanghaoList','Contract\officeController@fanghaoList');
    Route::get('salefanghaoList','Contract\officeController@salefanghaoList');
});

//hello world1
