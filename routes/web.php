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
    Route::post('addCopyImage','Contract\purchaseContractController@addCopyImage');
    Route::post('review','Contract\purchaseContractController@review');
    Route::post('weiYueInfo','Contract\purchaseContractController@weiYueInfo');
    Route::post('weiYueSave','Contract\purchaseContractController@weiYueSave');
    Route::post('isCopyComplete','Contract\purchaseContractController@isCopyComplete');
    Route::get('optimize','Contract\purchaseContractController@getOptimize');
    Route::get('approving','Contract\purchaseContractController@approving');
    Route::post('editTiaoKuan','Contract\purchaseContractController@editTiaoKuan');
    Route::get('confirm','Contract\purchaseContractController@confirm');
    Route::get('confirming','Contract\purchaseContractController@confirming');
    Route::get('violating','Contract\purchaseContractController@violating');
    Route::get('terminated','Contract\purchaseContractController@terminated');
    Route::get('releasing','Contract\purchaseContractController@releasing');
    Route::get('released','Contract\purchaseContractController@released');
    Route::get('releasedList','Contract\purchaseContractController@releasedList');
    Route::get('copyImageList','Contract\purchaseContractController@copyImageList');
    Route::get('deleteCopyImage','Contract\purchaseContractController@deleteCopyImage');
    Route::get('getCopyComplete','Contract\purchaseContractController@getCopyComplete');
    Route::post('zhanghaoSave','Contract\purchaseContractController@zhanghaoSave');
    Route::get('getZhanghaoList','Contract\purchaseContractController@getZhanghaoList');
    Route::get('deleteZhanghao','Contract\purchaseContractController@deleteZhanghao');
    Route::post('zhanghaoAlter','Contract\purchaseContractController@zhanghaoAlter');
    Route::post('hedanSave','Contract\purchaseContractController@hedanSave');
    Route::get('getHedanList','Contract\purchaseContractController@getHedanList');
    Route::get('deleteHedan','Contract\purchaseContractController@deleteHedan');
    Route::post('updataHedan','Contract\purchaseContractController@updataHedan');
    Route::post('saveyongyou','Contract\purchaseContractController@saveyongyou');
});
Route::resource('purchaseContract','Contract\purchaseContractController');
//装饰合同
Route::group(['prefix' => 'decoration'], function () {
    Route::get('index','Contract\decorationController@index');
    Route::get('show','Contract\decorationController@show');
    Route::post('submit','Contract\decorationController@submit');
    Route::post('store','Contract\decorationController@store');
    Route::get('status','Contract\decorationController@status');
});
//合同版本
Route::group(['prefix' => 'contractVersion'], function () {
    Route::get('index','Contract\contractVersionController@index');
    Route::get('status','Contract\contractVersionController@status');
});

//Route::get('purchaseContract/review','Contract\purchaseContractController@review');
Route::resource('brokerCompany','BrokerCompany\brokerCompanyController');
Route::resource('brokerCompanyUser','BrokerCompany\brokerCompanyUserController');
Route::resource('chuFangCommission','Commission\ChuFangCommissionController');
Route::resource('shouFangCommission','Commission\ShouFangCommissionController');
Route::resource('receivable','Commission\receivableController');
Route::resource('financeReceivable','Report\financeReceivableController');
Route::resource('accountsReceivable','Commission\accountsReceivableController');
Route::resource('receivableRecord','Commission\receivableRecordController');
Route::post('receivable/saveShouKuan','Commission\receivableController@saveShouKuan');
Route::post('financeReceivable/saveShouKuan','Report\financeReceivableController@saveShouKuan');
Route::resource('payable','Report\payableController');
Route::resource('payableRecord','Report\payableRecordController');
Route::resource('paymentRecord','Report\paymentRecordController');
Route::post('shouFangCommission/finishSK','Commission\ShouFangCommissionController@finishSK');
Route::post('payable/saveFuKuan','Report\payableController@saveFuKuan');
Route::post('payable/editDate','Report\payableController@editDate');
Route::post('payable/editMoney','Report\payableController@editMoney');
Route::resource('financePayable','Report\financePayableController');
Route::post('financePayable/rejectPayable','Report\financePayableController@rejectPayable');
Route::post('financePayable/confirmPayable','Report\financePayableController@confirmPayable');
Route::post('receivable/editDate','Commission\receivableController@editDate');
Route::post('receivable/editMoney','Commission\receivableController@editMoney');
Route::post('receivableRecord/cancelClaim','Commission\receivableRecordController@cancelClaim');
//消息列表
Route::resource('message','Message\messageController');

Route::post('message/acceptMessage','Message\messageController@acceptMessage');
Route::post('message/refuseMessage','Message\messageController@refuseMessage');

//出房合同分组
Route::group(['prefix' => 'saleContract'], function () {
    Route::post('addCopyImage','Contract\saleContractController@addCopyImage');
    Route::get('getchuzuren','Contract\saleContractController@getchuzuren');
    Route::post('submit','Contract\saleContractController@submit');
    Route::get('jieyue','Contract\saleContractController@jieyue');
    Route::post('getzyrNameList','Contract\saleContractController@getzyrNameList');
    Route::get('approving','Contract\saleContractController@approving');
    Route::get('confirm','Contract\saleContractController@confirm');
    Route::get('confirmed','Contract\saleContractController@confirmed');
    Route::get('violating','Contract\saleContractController@violating');
    Route::get('terminated','Contract\saleContractController@terminated');
    Route::get('TwiceReleasing','Contract\saleContractController@TwiceReleasing');
    Route::get('TwiceReleased','Contract\saleContractController@TwiceReleased');
    Route::get('releasedList','Contract\saleContractController@releasedList');
    Route::get('releasing','Contract\saleContractController@releasing');
    Route::get('released','Contract\saleContractController@released');
    Route::post('review','Contract\saleContractController@review');
    Route::post('jieyuesave','Contract\saleContractController@jieyuesave');
    Route::get('jieyuelist','Contract\saleContractController@jieyuelist');
    Route::post('weiYueInfo','Contract\saleContractController@weiYueInfo');
    Route::post('weiYueSave','Contract\saleContractController@weiYueSave');
    Route::get('copyImageList','Contract\saleContractController@copyImageList');
    Route::get('deleteCopyImage','Contract\saleContractController@deleteCopyImage');
    Route::post('isCopyComplete','Contract\saleContractController@isCopyComplete');
    Route::get('getCopyComplete','Contract\saleContractController@getCopyComplete');
    Route::post('hedanSave','Contract\saleContractController@hedanSave');
    Route::get('getHedanList','Contract\saleContractController@getHedanList');
    Route::get('deleteHedan','Contract\saleContractController@deleteHedan');
    Route::post('updataHedan','Contract\saleContractController@updataHedan');
    Route::post('getHedanqiannameList','Contract\saleContractController@getHedanqiannameList');
    Route::post('getHedanbumenList','Contract\saleContractController@getHedanbumenList');
    Route::post('saveyongyou','Contract\saleContractController@saveyongyou');
});
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
    Route::post('getGSSXDicList','BrokerCompany\brokerCompanyController@getGSSXDicList');
    Route::post('getFWDXDicList','BrokerCompany\brokerCompanyController@getFWDXDicList');
    Route::post('getYWQYDicList','BrokerCompany\brokerCompanyController@getYWQYDicList');
    Route::post('getXZQYDicList','BrokerCompany\brokerCompanyController@getXZQYDicList');
    Route::post('getJDDicList','BrokerCompany\brokerCompanyController@getJDDicList');
    Route::post('changeBrokerCompanyStatus','BrokerCompany\brokerCompanyController@changeBrokerCompanyStatus');
    Route::post('getXYDJDicList','BrokerCompany\brokerCompanyController@getXYDJDicList');
    Route::post('getYSLXRDicList','BrokerCompany\brokerCompanyController@getYSLXRDicList');
});
//渠道公司人员
Route::group(['prefix' => 'brokerCompanyUser'], function () {
    Route::post('getbkNameList','BrokerCompany\brokerCompanyUserController@getbkNameList');
    Route::post('changeBrokerCompanyUserStatus','BrokerCompany\brokerCompanyUserController@changeBrokerCompanyUserStatus');
    Route::post('getQDDJDicList','BrokerCompany\brokerCompanyUserController@getQDDJDicList');
    Route::post('checkPhone','BrokerCompany\brokerCompanyUserController@checkPhone');
    Route::post('checkName','BrokerCompany\brokerCompanyUserController@checkName');
});
//自由经纪人
Route::group(['prefix' => 'brokerUser'], function () {
    Route::post('changeBrokerUserStatus','BrokerCompany\brokerUserController@changeBrokerCompanyUserStatus');
});
Route::resource('brokerUser','BrokerCompany\brokerUserController');
Route::resource('brokerCompanyHistory','BrokerCompany\brokerCompanyHistoryController');
Route::resource('brokerCompanyUserHistory','BrokerCompany\brokerCompanyUserHistoryController');
Route::resource('brokerUserHistory','BrokerCompany\brokerUserHistoryController');

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
    Route::get('createFanghao','Contract\officeController@createFanghao');
    Route::get('shengyuechengzu','Contract\officeController@shengyuechengzu');
    Route::get('loudongRules','Contract\officeController@loudongRules');
});
Route::resource('payOrder','Report\payOrderController');
//hello world1
