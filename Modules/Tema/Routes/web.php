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

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin/temas'], function () {
   Route::get('/', 'TemaController@index');

   Route::get('/data', 'TemaController@data');
   Route::get('/create', 'TemaController@create');
   Route::get('{id}/edit', 'TemaController@edit');

   Route::post('/', 'TemaController@store');
   Route::put('/{id}', 'TemaController@update');
   Route::delete('/{id}', 'TemaController@destroy');
   Route::post('/{id}/foto', 'TemaController@updateFoto');
   Route::delete('/{id}/foto', 'TemaController@destroyFoto');
   Route::post('/{id}/clone', 'TemaController@cloneTema');
});
