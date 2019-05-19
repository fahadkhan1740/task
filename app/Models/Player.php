<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function scorecard()
    {
        return $this->hasOne(Scorecard::class);
    }
}
