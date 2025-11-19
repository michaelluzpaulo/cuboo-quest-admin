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

use Modules\Option\Http\Controllers\OptionController;

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin/scenarios'], function () {
   Route::get('/', 'ScenarioController@index');

   Route::get('/data', 'ScenarioController@data');
   Route::get('/create', 'ScenarioController@create');
   Route::get('{id}/edit', 'ScenarioController@edit');

   Route::post('/', 'ScenarioController@store');
   Route::put('/{id}', 'ScenarioController@update');
   Route::delete('/{id}', 'ScenarioController@destroy');

   Route::get('/{scenario_id}/options/data', [OptionController::class, "data"]);
   Route::get('/{scenario_id}/options/create', [OptionController::class, "create"]);
   Route::get('/{scenario_id}/options/{id}/edit', [OptionController::class, "edit"]);

   Route::post('/{scenario_id}/options/', [OptionController::class, "store"]);
   Route::put('/{scenario_id}/options/{id}', [OptionController::class, "update"]);
   Route::delete('/{scenario_id}/options/{id}', [OptionController::class, "destroy"]);
});
