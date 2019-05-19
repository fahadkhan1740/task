<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScorecardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scorecards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('player_id');
            $table->unsignedInteger('match_id');
            $table->string('status');
            $table->unsignedInteger('batting_runs');
            $table->unsignedInteger('batting_balls');
            $table->unsignedInteger('batting_fours');
            $table->unsignedInteger('batting_sixes');
            $table->float('strike_rate');
            $table->float('bowling_overs');
            $table->unsignedInteger('bowling_maiden');
            $table->unsignedInteger('bowling_runs');
            $table->unsignedInteger('bowling_wickets');
            $table->float('economy');
            $table->unsignedInteger('bowling_zeros');
            $table->unsignedInteger('bowling_fours');
            $table->unsignedInteger('bowling_sixes');
            $table->unsignedInteger('wide_balls');
            $table->unsignedInteger('no_balls');
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
        Schema::dropIfExists('scorecards');
    }
}
