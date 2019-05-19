<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

    public function matches()
    {
        return $this->hasMany(Match::class);
    }
}
