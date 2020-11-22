<?php

namespace Database\Seeders;

use App\Models\LeaderBoard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class GameUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::set('tablePrefix',"stack_");
        LeaderBoard::factory()->count(100)->create();
    }
}
