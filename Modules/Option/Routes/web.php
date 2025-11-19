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

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin/options'], function () {
   // Route::get('/', 'OptionController@index');

   // Route::get('/data', 'OptionController@data');
   // Route::get('/create', 'OptionController@create');
   // Route::get('{id}/edit', 'OptionController@edit');

   // Route::post('/', 'OptionController@store');
   // Route::put('/{id}', 'OptionController@update');
   // Route::delete('/{id}', 'OptionController@destroy');
});
