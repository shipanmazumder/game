<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BotController;
use App\Http\Controllers\API\GameUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/create-board",[GameUserController::class,'addUser'])->name('create-board');
Route::get("/show-leaderboard",[GameUserController::class],'leaderBoard')->name('show-leaderboard');

Route::post("/webhook",[BotController::class,'webHookPost']);
Route::get("/webhook",[BotController::class,'webHookGet']);
