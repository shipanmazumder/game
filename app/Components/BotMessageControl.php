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
        $position=$user->last_message_position+1;
        $message=BotMessage::where("position",$position)->where("status",1)->first();
        if($user && $message){
            $next_position=$position+1;
            $next_message=BotMessage::where("position",$next_position)->first();
             $user->last_message_position=$position;
             $user->message_count+=1;
             $user->last_message_time=date("Y-m-d H");
             $next_message_time=$next_message?$next_message->message_time:1;
             $user->next_message_time=date("Y-m-d H",strtotime("+".$next_message_time." hours"));
             $user->save();
        }
        if($message){
            // $attachmentMessage=array(
            //     "attachment" => array(
            //         "type" => "template",
            //         "payload" => array(
            //             "template_type" => "generic",
            //             "elements" => array(
            //                 array(
            //                     "title" => $message->title,
            //                     "image_url" => $message->image_url,
            //                     "subtitle" => $message->subtitle,
            //                     "default_action"=>array(
            //                         "type"=>"game_play"
            //                     ),
            //                     "buttons"=>array(
            //                         array(
            //                             "type"=>"game_play",
            //                             "title"=>$message->button_title,
            //                             "playload"=>$message->data?json_decode($message->data):""
            //                         )
            //                     )
            //                 )
            //             )
            //         )
            //     )
            // );
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
                    "id"=>$sender_psid
                ),
                "message"=>$attachmentMessage
            );
            $jsonData =json_encode($responData);
            $this->serverSend($jsonData);
        }
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
