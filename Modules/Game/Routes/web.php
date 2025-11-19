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

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin/games'], function () {
   Route::get('/', 'GameController@index');

   Route::get('/data', 'GameController@data');
   Route::get('/create', 'GameController@create');
   Route::get('{id}/edit', 'GameController@edit');

   Route::post('/', 'GameController@store');
   Route::put('/{id}', 'GameController@update');
   Route::delete('/{id}', 'GameController@destroy');
});

Route::group(['middleware' => ['web'], 'prefix' => 'admin/games'], function () {
   Route::get('/finaliza-partida/{id}', 'GameController@finalizaPartida');
});

Route::group(['middleware' => ['web'], 'prefix' => 'gm'], function () {
   Route::get('/{chave}', 'GameController@gm');
});
