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

Route::any('wechat/index', 'WechatController@index');
Route::get('wechat/create_menu', 'WechatController@create_menu');

Route::any('weibo/index', 'WeiboController@index');

