<?php

namespace App\Listeners;

use App\Events\MatchStartedEvent;
use App\Models\Team;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MatchProgressListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MatchStartedEvent  $event
     * @return void
     */
    public function handle(MatchStartedEvent $event)
    {
        $matchTeams = Team::with('players.scorecard')->whereIn('id', [$event->match->home_team_id, $event->match->away_team_id])->get();
        // teams have players
        // players have scorecard

        // update scorecards every 5 seconds by firing events

        // over 20 | 6 balls
        // one bowler | two batsmen: status => not out, rest_status => empty
        // next over new bowler same batsmen
        // runs 1,2,3,4,6
        // out bowled, catch | Extras: wide balls, no ball

        $probableRuns = [0,1,2,3,4,6];
        $probableBalls = ['No Ball', 'Wide Ball', 'Bowled', 'Catch out', 'Delivery'];
        // Loop through balls
        $totalBalls = env('OVERS') * 6;

        for ($i = 1; $i = env('OVERS'); $i++) {
            for ($j = 1; $j = 6;) {
                $ball = array_rand($probableBalls, 1);

                if ($probableBalls[$ball] !== 'Delivery') {
                    if ($probableBalls[$ball] === 'No Ball' || $probableBalls[$ball] === 'Wide Ball') {
                        $probableRuns = 1;
                        if ($probableBalls[$ball] === 'No Ball') {
                            // updated bowler "No balls"
                        } else {
                            // update bowler "Wide balls"
                        }
                    } else {
                        $probableRuns = 0;
                        // Remove current batsman
                        // Bring new batsman
                        // update batsman status
                        // update bowler wickets
                    }
                } else {
                    $run = array_rand($probableRuns, 1);

                    if ($probableRuns[$run] !== 0) {
                        if ($probableRuns[$run] % 2 !== 0) {
                            // switch batsmen
                        }
                    }

                    // update team score
                    // update batsmen runs, balls, strike_rate
                    // update bowler runs, overs, economy

                    $j++;
                }

            }
        }
    }
}
