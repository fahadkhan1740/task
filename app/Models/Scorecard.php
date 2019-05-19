<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scorecard extends Model
{
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function match()
    {
        return $this->belongsToMany(Match::class);
    }
}
