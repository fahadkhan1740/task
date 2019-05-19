<?php

namespace App\Repositories;

use App\Models\Match;

class LeagueRepository
{
    /**
     * Remove all the matches to generate a new league fixtures
     * @return mixed
     */
    public function resetFixtures()
    {
        return Match::truncate();
    }

    /**
     * Set fixtures for all Teams in a League
     * @param $teams
     * @return mixed
     */
    public function setFixtures($teams)
    {
        if (count($teams) % 2 != 0) {
            array_push($teams, 'bye');
        }

        $away = array_splice($teams, (count($teams) / 2));
        $home = $teams;

        for ($i = 0; $i < count($home) + count($away) - 1; $i++) {
            for ($j = 0; $j < count($home); $j++) {
                $round[$i][$j]['Home'] = $home[$j];
                $round[$i][$j]['Away'] = $away[$j];

                // Insert into matches table
                $this->createMatch($home, $j, $away);
            }

            if (count($home) + count($away) - 1 > 2) {
                $s = array_splice($home, 1, 1);
                $slice = array_shift($s);
                array_unshift($away, $slice);
                array_push($home, array_pop($away));
            }
        }

        return $round;
    }

    /**
     * Create a single fixture
     * @param $home
     * @param int $j
     * @param array $away
     */
    private function createMatch($home, int $j, array $away): void
    {
        $match = new Match();
        $match->home_team_id = $home[$j]['id'];
        $match->home_team_runs = 0;
        $match->home_team_wickets = 0;
        $match->home_team_overs = 0;
        $match->home_team_run_rate = 0;
        $match->away_team_id = $away[$j]['id'];
        $match->away_team_runs = 0;
        $match->away_team_wickets = 0;
        $match->away_team_overs = 0;
        $match->away_team_run_rate = 0;
        $match->status = 'Will Start';
        $match->result = 'Match has not started yet';
        $match->save();
    }
}
