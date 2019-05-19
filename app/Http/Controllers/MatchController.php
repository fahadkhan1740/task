<?php

namespace App\Http\Controllers;

use App\Models\Match;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * Fetch all the matches in a League
     * @return Match[]|Collection
     */
    public function index()
    {
        return Match::with('homeTeam')->with('awayTeam')->get();
    }
}
