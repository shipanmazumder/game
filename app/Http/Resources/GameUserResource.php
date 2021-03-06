<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "name"=>$this->gameUser->name??"",
            "user_unique_id"=>$this->gameUser->user_unique_id,
            "last_login_time"=>date("d-m-Y h:i:s A",strtotime($this->gameUser->last_login_time)),
            "last_message_time"=>$this->gameUser->last_message_time?date("d-m-Y h:i:s A",strtotime($this->gameUser->last_message_time)):"N/A",
            "next_message_time"=>date("d-m-Y h:i:s A",strtotime($this->gameUser->next_message_time)),
            "days"=>$this->getDays($this->gameUser->last_login_time),
            "level"=>$this->game_level,
            "score"=>$this->score,
        ];
    }
    public function getDays($dateTime)
    {
        $today=time();
        $last_login_date=strtotime($dateTime);
        $datediff = $today - $last_login_date;
        return round($datediff / (60 * 60 * 24));;
    }
}
