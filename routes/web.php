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
/**
 * Hprose-test
 */
use Hprose\Http\Server;
function hello($name){
    return "hello $name";
}

Route::get('/','DiffController@index');
Route::match(['get','post'],'/diff','DiffController@index');

Route::get('/hprose',function (){
    $server = new Server();
    $server -> addFunction("hello");
    $server -> start();die;
});

Route::get('/redis','PubSubController@pub');
Route::get('/index','PubSubController@index');
Route::get('/hprose','HproseController@index');