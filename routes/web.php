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

Route::get('/', 'wilayahController@index');
Route::get('/save_wilayah', 'wilayahController@save_wilayah')->name('save_wilayah');
Route::get('/show_wilayah', 'wilayahController@show_wilayah')->name('show_wilayah');
Route::get('/load_wilayah', 'wilayahController@load_wilayah')->name('load_wilayah');
Route::get('/update_wilayah', 'wilayahController@update_wilayah')->name('update_wilayah');
Route::get('/hapus_wilayah', 'wilayahController@hapus_wilayah')->name('hapus_wilayah');
