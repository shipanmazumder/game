<?php

use App\Components\Analytics;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\GameController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get("dashboard",[DashboardController::class,"index"])->name('dashboard');

    Route::get("game",[GameController::class,"index"])->name("game");
    Route::post("game",[GameController::class,"store"]);
    Route::get("game/{game}",[GameController::class,"edit"])->name('gameEdit');
    Route::post("game/update",[GameController::class,"update"])->name('gameUpdate');
    Route::get("game/control/{game}",[GameController::class,"control"])->name('gameControl');
});
Route::get("test",function(){
    $analytics=new Analytics;
    $rr=$analytics->setEvent("565","Message","SheduleMessage","ss");
    echo $rr;
    });
