<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            "name"=>"Action"
        ]);
        DB::table('categories')->insert([
            "name"=>"Adventure"
        ]);
        DB::table('categories')->insert([
            "name"=>"Board"
        ]);
        DB::table('categories')->insert([
            "name"=>"Card"
        ]);
        DB::table('categories')->insert([
            "name"=>"Casual"
        ]);
        DB::table('categories')->insert([
            "name"=>"Educational"
        ]);
        DB::table('categories')->insert([
            "name"=>"Puzzle"
        ]);
        DB::table('categories')->insert([
            "name"=>"Racing"
        ]);
        DB::table('categories')->insert([
            "name"=>"Simulation"
        ]);
    }
}
