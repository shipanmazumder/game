<?php

use App\Components\BotMessageControl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\GameUserController;
use App\Http\Controllers\Admin\BotMessaseController;

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
  $data=file_get_contents(public_path("data.json"));
  $users=collect(json_decode($data,true)['users']);

  foreach ($users->chunk(100) as $chunk):
    $data=[];
      foreach ($chunk as $key=>$user){
        //   $last_login_time=date("Y-m-d",strtotime("-".$user['Day']." days"));
        //   $newUser= DB::table('draw_game_users')->insertGetId([
        //       "user_unique_id"=>$key,
        //       "last_login_time"=>$last_login_time
        //   ]);
        //   DB::table('draw_leader_boards')->insert([
        //         'score'=>0,
        //         'game_user_id'=>$newUser,
        //         'game_level'=>$user['Level'],
        //         'last_update_time'=>date("Y-m-d H:i:s"),
        // ]);
      }
    endforeach;
});
Route::get("/send-message",function(){
    set_time_limit(300);
    ini_set("memory_limit",-1);
  $data=file_get_contents(public_path("data.json"));
  $users=collect(json_decode($data,true)['users']);
  $attachmentMessage=array(
    "attachment" => array(
        "type" => "template",
        "payload" => array(
            "template_type" => "generic",
            "elements" => array(
                array(
                    "title" =>"Can you draw it properly?",
                    "image_url" =>"https://s3.ap-south-1.amazonaws.com/doelcampus.instantgames/draw/1.png",
                    "subtitle" => "",
                    "default_action"=>array(
                        "type"=>"game_play"
                    ),
                    "buttons"=>array(
                            array(
                                "type"=>"game_play",
                                "title"=>"Draw Now"
                            )
                        )
                )
            )
        )
    )
);
  foreach ($users->chunk(100) as $chunk):
    $data=[];
      foreach ($chunk as $key=>$user){

        $responData=array(
            "recipient"=>array(
                "id"=>$key
            ),
            "message"=>$attachmentMessage
        );
        $jsonData =json_encode($responData);
        $url = 'https://graph.facebook.com/v8.0/me/messages?access_token=EAAEInhQd4XIBAIrXVZBDX2f9CZBWzxyRITCLrl9bcDj8VWREZAAUZBAuOxrMt7vowLor8BBNHIXSw47ZANu3H85GHzSz36rJ75yuXDIUFBRpMsZAZBv0yPZCmxftELvFZBUfwp19XjiEXRZBjwtwqU7m6CmbH9qWWsWbg9FzGr95BZArk4WYAIJ8fY9';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch); // user will get the message
      }
    endforeach;
});

