<?php

namespace App\Components;

use App\Models\Game;
use App\Models\GameUser;
use App\Models\BotMessage;
use Illuminate\Support\Facades\Config;

class BotMessageControl
{
    private $access_token="";

    public function messageSend($game,$sender_psid,$user_id,$time_stamp,$first)
    {
        Config::set('tablePrefix', $game->game_short_code."_");
        $this->access_token=$game->game_access_token;
        $user=GameUser::where("user_unique_id",$user_id)->first();
        if($first==true){
            $message=BotMessage::where("position",1)->first();
            if($user){
                 $user->last_message_ids=$message->id;
                 $user->sender_id=$sender_psid;
                 $user->message_count=1;
                 $user->first_message_time=date("Y-m-d H",$time_stamp);
                 $user->last_message_time=date("Y-m-d H",$time_stamp);
                 $user->next_message_time=date("Y-m-d H",strtotime("+3 hours",$time_stamp));
                 $user->save();
            }
        }else{
            $message_ids=explode(',',$user->last_message_ids);
            $position=2;
            $random=true;
            while($random){
                $rand=rand(1,5);
                if(!in_array($rand,$message_ids)){
                    $position=$rand;
                    $random=false;
                }
            }
            $message=BotMessage::where("position",$position)->first();
            if($user){
                 $user->last_message_ids=$user->last_message_ids.','.$message->id;
                 $time_stamp=strtotime($user->first_message_time);
                 $user->message_count+=1;
                 $user->last_message_time=date("Y-m-d H",strtotime($user->next_message_time));
                 $user->next_message_time=date("Y-m-d H",strtotime("+24 hours",$time_stamp));
                 $user->save();
            }
        }
        $attachmentMessage=array(
            "attachment" => array(
                "type" => "template",
                "payload" => array(
                    "template_type" => "generic",
                    "elements" => array(
                        array(
                            "title" => $message->message,
                            "image_url" => $message->image_url,
                            "subtitle" => "",
                            "default_action"=>array(
                                "type"=>"game_play"
                            ),
                            "buttons"=>array(
                                array(
                                    "type"=>"game_play",
                                    "title"=>"Play Now",
                                )
                            )
                        )
                    )
                )
            )
        );
        $responData=array(
            "recipient"=>array(
                "id"=>$sender_psid
            ),
            "message"=>$attachmentMessage
        );
        $jsonData =json_encode($responData);
        $this->serverSend($jsonData);
    }
    public function serverSend($jsonData)
    {
            $url = 'https://graph.facebook.com/v8.0/me/messages?access_token='.$this->access_token;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result = curl_exec($ch); // user will get the message
    }
}
