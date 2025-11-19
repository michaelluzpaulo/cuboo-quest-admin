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

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin/institucionais'], function () {
  Route::get('/', 'InstitucionalController@index');

  Route::get('/data', 'InstitucionalController@data');
  Route::get('/create', 'InstitucionalController@create');
  Route::get('{id}/edit', 'InstitucionalController@edit');

  Route::post('/', 'InstitucionalController@store');
  Route::put('/{id}', 'InstitucionalController@update');
  Route::delete('/{id}', 'InstitucionalController@destroy');
  Route::post('/{id}/foto', 'InstitucionalController@updateFoto');
  Route::delete('/{id}/foto', 'InstitucionalController@destroyFoto');
});
