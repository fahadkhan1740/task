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
            $table->string('status')->nullable();
            $table->unsignedInteger('batting_runs')->default(0);
            $table->unsignedInteger('batting_balls')->default(0);
            $table->unsignedInteger('batting_fours')->default(0);
            $table->unsignedInteger('batting_sixes')->default(0);
            $table->float('strike_rate')->default(0);
            $table->float('bowling_overs')->default(0);
            $table->unsignedInteger('bowling_maiden')->default(0);
            $table->unsignedInteger('bowling_runs')->default(0);
            $table->unsignedInteger('bowling_wickets')->default(0);
            $table->float('economy')->default(0);
            $table->unsignedInteger('bowling_zeros')->default(0);
            $table->unsignedInteger('bowling_fours')->default(0);
            $table->unsignedInteger('bowling_sixes')->default(0);
            $table->unsignedInteger('wide_balls')->default(0);
            $table->unsignedInteger('no_balls')->default(0);
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
