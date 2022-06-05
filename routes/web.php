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

use App\Http\Controllers\HomeGetController;

Route::get('/google', 'HomeGetController@get_google');
Route::get('/google2', 'HomeGetController@get_google2');
Route::get('/', 'HomeGetController@get_index');
Route::get('/index', 'HomeGetController@get_index_yonlendir');
Route::get('/home', 'HomeGetController@get_index_yonlendir');
Route::get('/anasayfa', 'HomeGetController@get_index_yonlendir');
Route::get('/gider-ekle', 'HomeGetController@get_gider_ekle');
Route::get('/rapor', 'HomeGetController@get_gider_rapor');

Route::post('/', 'HomePostController@post_index_sil');
Route::post('/gider-ekle', 'HomePostController@post_gider_ekle');
Route::post('/duzenle', 'HomePostController@post_gider_duzenle');




