<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("game_short_code")->unique();
            $table->string("app_id")->unique();
            $table->string("app_secret")->unique();
            $table->string("game_unique_id")->unique();
            $table->text("game_access_token")->nullable();
            $table->text("game_verify_token")->nullable();
            $table->unsignedBigInteger("category_id");
            $table->text("description")->nullable();
            $table->boolean("status")->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
