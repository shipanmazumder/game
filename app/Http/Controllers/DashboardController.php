<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['games']=Game::with("category")->orderBy("name","asc")->get()->chunk(4);
        return Inertia::render('Dashboard/Index',$data);
    }
}
