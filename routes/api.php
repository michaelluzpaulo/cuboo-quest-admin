<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
   Route::post('login', 'login');
   Route::post('register', 'register');
   Route::post('logout', 'logout');
   Route::post('refresh', 'refresh');
});

Route::controller(ApiController::class)->group(function () {
   Route::get('/tema/{code}', 'tema');
   // Route::post('/think', 'think');
   Route::put('/game-update', 'gameUpdate');
   Route::get('/game-sala/{id}', 'getGameSala');
   Route::get('/game/{id}', 'getGame');
   Route::get('/game-init-game/{id}', 'getGameInit');

   Route::get('/game/{id}/go-players-game', 'goPlayersGame');
   Route::post('/game/{id}/player-finish', 'playerFinish');
   Route::post('/game/{id}/game-finish', 'gameFinish');


   Route::get('/game/{id}/scenario', 'scenario');
   Route::get('/game/{id}/player-status', 'getPlayerStatus');
   Route::get('/game/{id}/ranking', 'ranking');
   Route::post('/game/{gameId}/answer', 'storeAnswer');
   Route::get('/game/{gameId}/graph', 'graphForGame');
});
