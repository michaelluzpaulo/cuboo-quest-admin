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

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin/app-usuarios'], function () {

  Route::get('/', 'AppUsuarioController@index');
  Route::get('data', 'AppUsuarioController@data');
  Route::get('create', 'AppUsuarioController@create');
  Route::get('{id}/edit', 'AppUsuarioController@edit');

  Route::post('/', 'AppUsuarioController@store');
  Route::put('/{id}', 'AppUsuarioController@update');
  Route::delete('/{id}', 'AppUsuarioController@destroy');
});
