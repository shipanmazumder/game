<?php

use App\Components\Analytics;
use App\Http\Controllers\Admin\BotMessaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\GameUserController;

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

Route::get('/', function () {
    return redirect()->route("login");
});

Auth::routes([
    "register"=>false
]);


Route::group(['middleware' => ['auth']], function () {
    Route::get("dashboard",[DashboardController::class,"index"])->name('dashboard');
    Route::get("game/users/{game}",[GameUserController::class,"index"])->name('gameUsers');

    Route::get("game",[GameController::class,"index"])->name("game");
    Route::post("game",[GameController::class,"store"]);
    Route::get("game/{game}",[GameController::class,"edit"])->name('gameEdit');
    Route::post("game/update",[GameController::class,"update"])->name('gameUpdate');
    Route::get("game/control/{game}",[GameController::class,"control"])->name('gameControl');

    Route::get("bot-message",[BotMessaseController::class,"index"])->name('botMessage');
    Route::get("bot-message/{game}",[BotMessaseController::class,"gameBotMessage"])->name('gameBotMessage');
    Route::post("bot-message/{game}/add",[BotMessaseController::class,"gameBotMessageAdd"])->name('gameBotMessageAdd');
    Route::get("bot-message/{game}/edit/{message}",[BotMessaseController::class,"gameBotMessageEdit"])->name('gameBotMessageEdit');
    Route::post("bot-message/{game}/update/{message}",[BotMessaseController::class,"gameBotMessageUpdate"])->name('gameBotMessageUpdate');
    Route::get("bot-message/{game}/delete/{message}",[BotMessaseController::class,"gameBotMessageDelete"])->name('gameBotMessageDelete');
    Route::get("bot-message/{game}/publish/{message}",[BotMessaseController::class,"gameBotMessagePublish"])->name('gameBotMessagePublish');
});
Route::get("test",function(){
    $analytics=new Analytics;
    $rr=$analytics->setEvent("565","Message","SheduleMessage","ss");
    echo $rr;
    });
