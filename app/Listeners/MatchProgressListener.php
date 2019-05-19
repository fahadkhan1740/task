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
     * @param MatchStartedEvent $event
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

        $probableRuns = [0, 1, 2, 3, 4, 6];
        $probableBalls = ['No Ball', 'Wide Ball', 'Bowled', 'Catch out', 'Delivery'];

        // Loop through balls
        $totalBalls = env('OVERS') * 6;

        for ($i = 1; $i = env('OVERS'); $i++) {
            for ($j = 1; $j = 6;) {
                $ball = array_rand($probableBalls, 1);

                if ($this->isNotDelivery($probableBalls, $ball)) {
                    if ($this->isNoOrWideBall($probableBalls, $ball)) {
                        $probableRuns = 1;
                        // update batting team runs
                        if ($this->isNoBall($probableBalls, $ball)) {
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
                        if ($this->isOdd($probableRuns, $run)) {
                            // switch batsmen
                        }
                    }

                    $j++;
                }

                // update team score
                // update batsmen runs, balls, strike_rate
                // update bowler runs, overs, economy

            }
        }
    }

    /**
     * @param array $probableBalls
     * @param $ball
     * @return bool
     */
    private function isNoOrWideBall(array $probableBalls, $ball): bool
    {
        return $this->isNoBall($probableBalls, $ball) || $probableBalls[$ball] === 'Wide Ball';
    }

    /**
     * @param array $probableBalls
     * @param $ball
     * @return bool
     */
    private function isNotDelivery(array $probableBalls, $ball): bool
    {
        return $probableBalls[$ball] !== 'Delivery';
    }

    /**
     * @param array $probableBalls
     * @param $ball
     * @return bool
     */
    private function isNoBall(array $probableBalls, $ball): bool
    {
        return $probableBalls[$ball] === 'No Ball';
    }

    /**
     * @param $probableRuns
     * @param $run
     * @return bool
     */
    private function isOdd($probableRuns, $run): bool
    {
        return $probableRuns[$run] % 2 !== 0;
    }
}
