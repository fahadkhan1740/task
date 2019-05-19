<?php


namespace App\Repositories;


use App\Models\Scorecard;

class MatchRepository
{
    /**
     * Start a match | Create a scorecard for a match
     * @param $match
     * @return bool
     */
    public function startMatch($match)
    {
        $match->load('homeTeam.players', 'awayTeam.players');

        // Create scorecard for home team
        $match->homeTeam->players->map(function ($player) use ($match) {
            $scorecard = new Scorecard;
            $scorecard->player_id = $player->id;
            $scorecard->match_id = $match->id;
            $scorecard->save();
        });

        // Create scorecard for away team
        $match->awayTeam->players->map(function ($player) use ($match) {
            $scorecard = new Scorecard;
            $scorecard->player_id = $player->id;
            $scorecard->match_id = $match->id;
            $scorecard->save();
        });

        return true;
    }
}
