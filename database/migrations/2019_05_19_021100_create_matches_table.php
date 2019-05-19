<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('home_team_id');
            $table->unsignedInteger('home_team_runs');
            $table->unsignedInteger('home_team_wickets');
            $table->unsignedInteger('home_team_overs');
            $table->unsignedInteger('home_team_run_rate');
            $table->unsignedInteger('away_team_id');
            $table->unsignedInteger('away_team_runs');
            $table->unsignedInteger('away_team_wickets');
            $table->unsignedInteger('away_team_overs');
            $table->unsignedInteger('away_team_run_rate');
            $table->string('status');
            $table->string('result');
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
        Schema::dropIfExists('matches');
    }
}
