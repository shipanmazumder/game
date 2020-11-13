<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\GameRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class GameController extends Controller
{
    public function index()
    {
        $data['add']=true;
        $data['categories']=Category::where("status",1)->orderBy("name","asc")->get();
        $data['games']=Game::with("category")->orderBy("name","asc")->get();
        return Inertia::render('Game/Index',$data);
    }
    public function store(GameRequest $request)
    {
        $game=Game::create([
            "name"=>$request->name,
            "app_id"=>$request->app_id,
            "category_id"=>$request->category_id,
            "description"=>$request->description,
            "game_short_code"=>$request->game_short_code,
            "game_unique_id"=>Str::random(8),
            "game_access_token"=>$request->game_access_token,
            "game_verify_token"=>$request->game_verify_token,
        ]);
        Schema::create($game->game_short_code.'_game_users', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("user_unique_id")->unique();
            $table->string("sender_id")->nullable();
            $table->string("image")->nullable();
            $table->dateTime("last_login_time");
            $table->dateTime("first_message_time")->nullable();
            $table->dateTime("last_message_time")->nullable();
            $table->dateTime("next_message_time")->nullable();
            $table->string("last_message_ids")->nullable();
            $table->tinyInteger("message_count")->default(0);
            $table->timestamps();
        });
        Schema::create($game->game_short_code.'_leader_boards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_user_id')->index();
            $table->unsignedBigInteger('score')->default(0)->index();
            $table->dateTime('last_update_time');
            $table->timestamps();
        });
        Schema::create($game->game_short_code.'_bot_messages', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->string('image_url');
            $table->integer('position');
            $table->timestamps();
        });
        return redirect()->route("game");
    }
    public function edit(Game $game)
    {
        $data['edit']=true;
        $data['gameObject']=$game;
        $data['categories']=Category::where("status",1)->orderBy("name","asc")->get();
        $data['games']=Game::with("category")->orderBy("name","asc")->get();
        return Inertia::render('Game/Index',$data);
    }
    public function update(GameRequest $request)
    {
        $data=$request->all();
        unset($data['game_short_code']);
        unset($data['created_at']);
        unset($data['deleted_at']);
        unset($data['updated_at']);
        Game::where("id",request()->input("id"))->update($data);
        return redirect()->route("game");
    }
    public function control(Game $game)
    {
        $game->status=!$game->status;
        $game->save();
        return redirect()->route("game");
    }
}
