<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GameUser;
use App\Models\LeaderBoard;
use Illuminate\Support\Facades\Config;

class GameUserController extends Controller
{
   public function index(Game $game)
   {
       $this->setTable($game);
        $data['users']=LeaderBoard::with("gameUser")->orderBy("score","desc")->paginate(10);
        return Inertia::render('Game/Users',$data);
   }
   public function setTable(Game $game)
   {
       Config::set('tablePrefix', $game->game_short_code."_");
   }
}
