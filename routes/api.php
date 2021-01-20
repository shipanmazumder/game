<?php

use App\Models\Game;
use App\Models\BotMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
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

Route::post("/delete-user",[GameUserController::class,'deleteUser']);
Route::get("/deletion",[GameUserController::class,'userDeletion'])->name("userDeletion");
Route::get("/send-message",function(Request $request){
    $games=Game::where("status",1)->latest()->first();
    $users=DB::table('happy_game_users')
    ->where("user_unique_id","5438317146193745")
    ->whereNotNull("sender_id")
    ->first();
    $message=DB::table('happy_bot_messages')->where("position",1)->where("status",1)->first();
    $attachmentMessage=array(
        "attachment" => array(
            "type" => "template",
            "payload" => array(
                "template_type" => "generic",
                "elements" => array(
                    array(
                        "title" => $message->title,
                        "image_url" =>$message->image_url,
                        "subtitle" => $message->subtitle,
                        "default_action"=>array(
                            "type"=>"game_play"
                        ),
                        "buttons"=>json_decode($message->data)
                    )
                )
            )
        )
    );
    $responData=array(
        "recipient"=>array(
            "id"=>$users->sender_id
        ),
        "message"=>$attachmentMessage
    );
    $jsonData =json_encode($responData);
    $url = 'https://graph.facebook.com/v8.0/me/messages?access_token='.$games->game_access_token;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch); // user will get the message

});
