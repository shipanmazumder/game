<?php

namespace App\Http\Controllers\API;

use App\Models\Game;
use App\Models\GameUser;
use Illuminate\Http\Request;
use App\Components\Analytics;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Components\BotMessageControl;
use Illuminate\Support\Facades\Config;

class BotController extends Controller
{
    private $botControl="";
    private $analytics="";
    public function __construct()
    {
        $this->botControl=new BotMessageControl();
        $this->analytics=new Analytics();
    }

    public function webHookGet()
    {
        $challenge=request()->input('hub_challenge');
        $token=request()->input('hub_verify_token');
            if(Game::where("game_verify_token",$token)->first()){
                echo $challenge;
            }
    }
    public function webHookPost(Request $request)
    {
        if($request->object=="page"){
            foreach($request->entry as $key=>$value){
                    $webhook_event = $value['messaging'][0];
                    $time_stamp=$value['time']/1000;
                    $sender_psid=$webhook_event['sender']["id"];
                    if(isset($webhook_event['game_play'])){
                        $user_id=$webhook_event['game_play']['player_id'];
                        $game=Game::where("app_id",$webhook_event['game_play']['game_id'])->first();
                        if($game){
                            $this->analytics->setEvent($user_id,"GameExit","Exit");
                            $this->profileUpdate($game,$user_id);
                            //$this->botControl->messageSend($game,$sender_psid,$user_id,$time_stamp,true);
                        }
                    }
            }
        }
    }
    public function profileUpdate($game,$user_id)
    {
        Config::set('tablePrefix', $game->game_short_code."_");
        $user=GameUser::where("user_unique_id",$user_id)->first();
        if($user){
            $user->last_login_time=date("Y-m-d H:i:s");
            $user->save();
        }
    }
}
