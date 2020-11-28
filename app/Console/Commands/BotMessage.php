<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Components\Analytics;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Components\BotMessageControl;

class BotMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:botmessage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Meena bot message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $botControl=new BotMessageControl();
        $analytics=new Analytics();
        $games=Game::where("status",1)->get();
        foreach($games as $key=>$game){
            $users=DB::table($game->game_short_code.'_game_users')
                    ->where("message_count","<",5)
                    ->whereNotNull("sender_id")
                    ->where("next_message_time",date("Y-m-d H").":00:00")
                    ->orderBy("id",'desc')
                    ->chunk(100,function($users) use ($botControl,$game,$analytics){
                        foreach ($users as $user) {
                            $analytics->setEvent($user->user_unique_id,"BotMessage","SheduleMessage",$game->game_short_code);
                            $botControl->messageSend($game,$user->sender_id,$user->user_unique_id,$user->first_message_time,false);
                        }
                    });
        }
    }
}
