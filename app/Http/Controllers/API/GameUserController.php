<?php

namespace App\Http\Controllers\API;

use App\Models\Game;
use App\Models\GameUser;
use App\Models\LeaderBoard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Components\Analytics;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

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
                'game_level'=>$request->game_level,
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
                    ->select( $game_id.'_game_users.name', $game_id.'_game_users.image', $game_id.'_leader_boards.score')
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
                ->select($game_id.'_game_users.name',$game_id.'_game_users.image', $game_id.'_leader_boards.score')
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
    public function deleteUser(Request $request)
    {
        $signed_request = $_POST['signed_request'];
        $data = $this->parse_signed_request($signed_request);
        Log::debug('data',['signed_data'=>$data]);
        // if($data==null){
        //     return $data;
        // }
        // $user_id = $data['user_id'];

        // $confirmation_code = Str::random(8);
        // while (DB::table('user_delete_histories')->where("confirmation_code", $confirmation_code)->exists()) {
        //   $confirmation_code = Str::random(8);
        // }

        // DB::beginTransaction();
        // try {
        //     $user=GameUser::where("user_unique_id",$user_id)->first();
        //     if($user){
        //         LeaderBoard::where("game_user_id",$user->id)->delete();
        //         $user->delete();
        //         DB::table('user_delete_histories')->insert(["id"=>Str::uuid(),'confirmation_code'=>$confirmation_code]);
        //     }
        //     DB::commit();

        // }catch(\Exception $exception){
        //     DB::rollBack();
        // }

        // $status_url = route("userDeletion",['id'=>$confirmation_code]); // URL to track the deletion
        // $data = array(
        //   'url' => $status_url,
        //   'confirmation_code' => $confirmation_code
        // );

        echo json_encode($data);
    }

    public function userDeletion()
    {
        $confirmation_code=\request()->input("id");
        $exits=DB::table('user_delete_histories')->where("confirmation_code", $confirmation_code)->exists();
        if($exits){
            return view('success');
        }else{
            return view('fail');
        }

    }
    public function parse_signed_request($signed_request) {
          list($encoded_sig, $payload) = explode('.', $signed_request, 2);

          $secret = "c31330161aa60c04f19a0a5681470d17"; // Use your app secret here

          // decode the data
          $sig = $this->base64_url_decode($encoded_sig);
          $data = json_decode($this->base64_url_decode($payload), true);

          // confirm the signature
        //   $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        //   if ($sig !== $expected_sig) {
        //     error_log('Bad Signed JSON signature!');
        //     return null;
        //   }

          return $data;
    }
    public function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
