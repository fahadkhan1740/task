<?php

namespace App\Http\Controllers;

use App\Models\Scorecard;
use Illuminate\Http\Request;

class ScorecardController extends Controller
{
    public function getScorecard($matchId)
    {
        return Scorecard::where('match_id', $matchId)->first();
    }
}
