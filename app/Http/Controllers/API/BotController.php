<?php

namespace App\Http\Controllers\API;

use App\Models\Game;
use App\Models\GameUser;
use App\Models\BotMessage;
use App\Models\LeaderBoard;
use Illuminate\Http\Request;
use App\Components\Analytics;
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
                            $this->profileUpdate($game,$user_id,$sender_psid);
                            //$this->botControl->messageSend($game,$sender_psid,$user_id,$time_stamp,true);
                        }
                    }
            }
        }
    }
    public function profileUpdate($game,$user_id,$sender_psid)
    {
        Config::set('tablePrefix', $game->game_short_code."_");
        $user=GameUser::where("user_unique_id",$user_id)->first();
        $next_message=BotMessage::where("position",1)->first();
        $next_message_time=$next_message?$next_message->message_time:1;
        if($user){
            $user->last_message_position=0;
            $user->sender_id=$sender_psid;
            $user->message_count+=1;
            $user->last_message_time=date("Y-m-d H");
            $user->next_message_time=date("Y-m-d H",strtotime("+".$next_message_time." hours"));
            $user->last_login_time=date("Y-m-d H:i:s");
            $user->save();
        }else{
            $this->analytics->setEvent($user_id,"NewUser","Register",$game->game_short_code);
            $newUser=GameUser::create([
                "name"=>null,
                "user_unique_id"=>$user_id,
                "sender_id"=>$sender_psid,
                "image"=>null,
                "last_message_position"=>0,
                "next_message_time"=>date("Y-m-d H",strtotime("+".$next_message_time." hours")),
                "last_login_time"=>date("Y-m-d H:i:s")
            ]);
            LeaderBoard::create([
                'score'=>0,
                'game_user_id'=>$newUser->id,
                'last_update_time'=>date("Y-m-d H:i:s"),
            ]);
        }
    }
}
