<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public function league()
    {
        return $this->belongsToMany(League::class);
    }

    public function scorecard()
    {
        return $this->hasMany(Scorecard::class);
    }

    public function homeTeam()
    {
        return $this->hasOne(Team::class, 'id', 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->hasOne(Team::class, 'id', 'away_team_id');
    }
}
