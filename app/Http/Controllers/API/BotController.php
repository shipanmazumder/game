<?php

namespace App\Http\Controllers\API;

use App\Components\Analytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Components\BotMessageControl;
use App\Models\Game;

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
        Log::debug("test",['test'=>$request->all()]);
        if($request->object=="page"){
            foreach($request->entry as $key=>$value){
                    $webhook_event = $value['messaging'][0];
                    $time_stamp=$value['time']/1000;
                    $sender_psid=$webhook_event['sender']["id"];
                    if($webhook_event['game_play']){
                        $user_id=$webhook_event['game_play']['player_id'];
                        $game=Game::where("app_id",$webhook_event['game_play']['game_id'])->first();
                        if($game){
                            $this->analytics->setEvent($user_id,"GameExit","Exit");
                            $this->botControl->messageSend($game,$sender_psid,$user_id,$time_stamp,true);
                        }
                    }
            }
        }
    }
}
