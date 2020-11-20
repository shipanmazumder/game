<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use Inertia\Inertia;
use App\Models\BotMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class BotMessaseController extends Controller
{
    public function index()
    {
        $data['add']=true;
        $data['games']=Game::with("category")->orderBy("name","asc")->get()->chunk(4);
        return Inertia::render('Botmessage/Index',$data);
    }
    public function gameBotMessage(Game $game)
    {
        $this->setTable($game);
        $data['add']=true;
        $data['game']=$game;
        $data['messages']=BotMessage::all();
        return Inertia::render('Botmessage/Message',$data);
    }
    public function gameBotMessageAdd(Request $request,Game $game)
    {
        $this->setTable($game);
        $validatedData = $request->validate([
            'message' => 'required',
            'image_url' => 'required',
            'position' => 'required',
        ]);
        $game=BotMessage::create($validatedData);
        return redirect()->route("gameBotMessage",['game'=>$game->id]);
    }
    public function gameBotMessageEdit(Game $game,$id)
    {
        $this->setTable($game);
        $data['edit']=true;
        $data['messageObj']=BotMessage::where("id",$id)->first();
        $data['game']=$game;
        $data['messages']=BotMessage::all();
        return Inertia::render('Botmessage/Message',$data);
    }
    public function gameBotMessageUpdate(Request $request,Game $game,$id)
    {
        $this->setTable($game);
        $validatedData = $request->validate([
            'message' => 'required',
            'image_url' => 'required',
            'position' => 'required',
        ]);
        BotMessage::where("id",$request->id)->update($validatedData);
        return redirect()->route("gameBotMessage",['game'=>$game->id]);
    }
    public function gameBotMessageDelete(Game $game,$id)
    {
        $this->setTable($game);
        BotMessage::where("id",$id)->delete();
        return redirect()->route("gameBotMessage",['game'=>$game->id]);
    }
    public function setTable(Game $game)
    {
        Config::set('tablePrefix', $game->game_short_code."_");
    }
}
