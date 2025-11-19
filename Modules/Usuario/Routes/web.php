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


// Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'sistema/usuarios', 'namespace' => 'Modules\Usuario\Http\Controllers'], function () {
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin/usuarios'], function () {

  Route::get('/', 'UsuarioController@index');
  Route::get('data', 'UsuarioController@data');
  Route::get('create', 'UsuarioController@create');
  Route::get('{id}/edit', 'UsuarioController@edit');

  Route::post('/', 'UsuarioController@store');
  Route::put('/{id}', 'UsuarioController@update');
  Route::delete('/{id}', 'UsuarioController@destroy');
});


Route::group(['middleware' => ['web'], 'prefix' => 'admin/minha-conta'], function () {
  Route::get('{id}/editProfile', 'UsuarioController@editProfile');
  Route::put('/{id}', 'UsuarioController@updateProfile');
});
