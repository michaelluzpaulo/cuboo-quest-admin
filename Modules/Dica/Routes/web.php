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

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin/dicas'], function () {
  Route::get('/', 'DicaController@index');

  Route::get('/data', 'DicaController@data');
  Route::get('/create', 'DicaController@create');
  Route::get('{id}/edit', 'DicaController@edit');

  Route::post('/', 'DicaController@store');
  Route::put('/{id}', 'DicaController@update');
  Route::delete('/{id}', 'DicaController@destroy');
  Route::post('/{id}/foto', 'DicaController@updateFoto');
  Route::delete('/{id}/foto', 'DicaController@destroyFoto');
});
