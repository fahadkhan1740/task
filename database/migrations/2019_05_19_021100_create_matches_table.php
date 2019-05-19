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
            $table->unsignedInteger('home_team_runs')->default(0);
            $table->unsignedInteger('home_team_wickets')->default(0);
            $table->unsignedInteger('home_team_overs')->default(0);
            $table->unsignedInteger('home_team_run_rate')->default(0);
            $table->unsignedInteger('away_team_id');
            $table->unsignedInteger('away_team_runs')->default(0);
            $table->unsignedInteger('away_team_wickets')->default(0);
            $table->unsignedInteger('away_team_overs')->default(0);
            $table->unsignedInteger('away_team_run_rate')->default(0);
            $table->string('status')->nullable();
            $table->string('result')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
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
