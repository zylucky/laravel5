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

Route::get('/', function () {
    return view('welcome');
});


//->where('id', '[0-9]+');
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
    return $postId.$commentId;
});
Route::get('user/profile', function () {
    //
})->name('profile');

Route::get('user/{id}', 'UserController@show');

/*Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});*/
Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/article/create','ArticleController@create');
Route::post('/article','ArticleController@store');

Route::resource('test', 'TestController');