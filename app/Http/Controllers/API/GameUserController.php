<?php

namespace App\Http\Controllers\API;

use App\Models\Game;
use App\Models\GameUser;
use App\Models\LeaderBoard;
use Illuminate\Http\Request;
use App\Components\Analytics;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class GameUserController extends Controller
{
    private $analytics="";
    public function __construct()
    {
        $this->analytics=new Analytics();
    }
    public function addUser(Request $request)
    {
        $request->validate([
            'app_id' => 'required',
            'name' => 'required',
            'user_unique_id' => 'required',
            'image_url' => 'required',
            'score' => 'required|numeric'
        ]);
        $game=Game::where("app_id",$request->app_id)->firstOrFail();
        Config::set('tablePrefix', $game->game_short_code."_");
        $user = GameUser::with("leaderBoard")->where('user_unique_id', $request->user_unique_id)->first();
        if($user){
            $this->analytics->setEvent($request->user_unique_id,"OldUser","Update",$game->game_short_code);
            if($user->leaderBoard){
                if($user->leaderBoard->score<$request->score){
                    $user->leaderBoard->score=$request->score;
                    $user->leaderBoard->last_update_time=date("Y-m-d H:i:s");
                    $user->leaderBoard->save();
                }
            }
            $user->last_login_time=date("Y-m-d H:i:s");
        }else{
            $this->analytics->setEvent($request->user_unique_id,"NewUser","Register",$game->game_short_code);
            $newUser=GameUser::create([
                "name"=>$request->name,
                "user_unique_id"=>$request->user_unique_id,
                "image"=>$request->image_url,
                "last_login_time"=>date("Y-m-d H:i:s")
            ]);
            LeaderBoard::create([
                'score'=>$request->score,
                'game_user_id'=>$newUser->id,
                'last_update_time'=>date("Y-m-d H:i:s"),
            ]);
        }
        return $this->leaderBoard($request);
        // return response()->json([
        //     "status"=>true
        // ],200);
    }
    public function leaderBoard(Request $request)
    {
        $game=Game::where("app_id",$request->app_id)->firstOrFail();
        $game_id=$game->game_short_code;
        $this->analytics->setEvent($request->user_unique_id,"LeaderBoard","Click LeaderBoard",$game->game_short_code);
        $user_unique_id=request()->input("user_unique_id");
        $leaderBoard=DB::table( $game_id.'_leader_boards')
                    ->join( $game_id.'_game_users', $game_id.'_leader_boards.game_user_id','=', $game_id.'_game_users.id')
                    ->select( $game_id.'_game_users.name', $game_id.'_game_users.user_unique_id', $game_id.'_game_users.image', $game_id.'_leader_boards.score')
                    ->orderBy( $game_id.'_leader_boards.score',"desc")
                    ->orderBy( $game_id.'_leader_boards.last_update_time',"asc")
                    ->take(10)
                    ->get();
        if ($leaderBoard->isEmpty()) {
            return response()->json(['message' => 'No user found',"code"=>404], 200);
        }
        $leaderBoard->map(function ($user, $key) {
            $user->position = $key + 1;
            return $user;
        });
        $users =DB::table($game_id.'_leader_boards')
                ->join( $game_id.'_game_users', $game_id.'_leader_boards.game_user_id','=',$game_id.'_game_users.id')
                ->select($game_id.'_game_users.name', $game_id.'_game_users.user_unique_id',$game_id.'_game_users.image', $game_id.'_leader_boards.score')
                ->orderBy($game_id.'_leader_boards.score',"desc")
                ->orderBy($game_id.'_leader_boards.last_update_time',"asc")
                ->get();
        $userIndex = $users->search(function ($user) use ($user_unique_id) {
            return $user->user_unique_id==$user_unique_id;
        });
        if ($userIndex !== false) {
            $myPosition =DB::table($game_id.'_leader_boards')
                        ->join( $game_id.'_game_users',$game_id.'_leader_boards.game_user_id','=', $game_id.'_game_users.id')
                        ->select($game_id.'_game_users.name', $game_id.'_game_users.user_unique_id', $game_id.'_game_users.image', $game_id.'_leader_boards.score')
                        ->where($game_id.'_game_users.user_unique_id',$user_unique_id)
                        ->orderBy($game_id.'_leader_boards.score',"desc")
                        ->orderBy($game_id.'_leader_boards.last_update_time',"asc")
                        ->first();
            $myPosition->position = $userIndex + 1;
        } else {
            $myPosition = null;
        }
        $data['leaderBoard']=$leaderBoard;
        $data['myPosition']=$myPosition;
        return response()->json(['message' => 'LeaderBoard',"code"=>200,'data'=>$data], 200);
    }
}
