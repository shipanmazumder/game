<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameUserResource;
use App\Models\GameUser;
use App\Models\LeaderBoard;
use Illuminate\Support\Facades\Config;

class GameUserController extends Controller
{
   public function index(Game $game)
   {
       $this->setTable($game);
        $users=LeaderBoard::with("gameUser")->orderBy("last_login_time","desc")->paginate(10);
        $data['users']=GameUserResource::collection($users);
        return Inertia::render('Game/Users',$data);
   }
   public function setTable(Game $game)
   {
       Config::set('tablePrefix', $game->game_short_code."_");
   }
}
