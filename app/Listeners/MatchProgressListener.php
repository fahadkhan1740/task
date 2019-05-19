<?php

namespace App\Listeners;

use App\Events\MatchStartedEvent;
use App\Models\Team;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class MatchProgressListener
{
    private $batsmanOnStrike;
    private $batsmanOffStrike;
    private $currentBowler;
    private $isDelivery;
    private $homeTeamBatsmen;
    private $awayTeamBowlers;

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
        $homeTeam = Team::with('players.scorecard')->with('league')->find($event->match->home_team_id);
        $awayTeam = Team::with('players.scorecard')->with('league')->find($event->match->away_team_id);
        // teams have players
        // players have scorecard

        $this->homeTeamBatsmen = $homeTeam->players->filter(function ($player) {
            return $player->type === 'batsmen';
        });

        $homeTeamBowlers = $homeTeam->players->filter(function ($player) {
            return $player->type === 'bowler';
        });

        $awayTeamBatsmen = $awayTeam->players->filter(function ($player) {
            return $player->type === 'batsmen';
        });

        $this->awayTeamBowlers = $awayTeam->players->filter(function ($player) {
            return $player->type === 'bowler';
        });

        $this->batsmanOnStrike = $this->homeTeamBatsmen[0];
        $this->batsmanOffStrike = $this->homeTeamBatsmen[1];

        $this->currentBowler = $this->awayTeamBowlers[4];

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

        for ($over = 0; $over < env('OVERS'); $over++) {
            for ($ball = 0; $ball < 6;) {
                Log::debug('ball count');
                Log::debug($ball);
                $this->isDelivery = false;

                $balled = array_rand($probableBalls, 1);

                $this->isValidOrInvalidDelivery($probableBalls, $balled, $probableRuns);

                if ($this->isDelivery) {
                    $ball++;
                }
                // update team score
                // update batsmen runs, balls, strike_rate | Complete
                // update bowler runs, overs, economy

            }
            $this->updateBowler($over);
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

    /**
     * @param array $probableBalls
     * @param $ball
     */
    private function isExtras(array $probableBalls, $ball): void
    {
        if ($this->isNoBall($probableBalls, $ball)) {
            // updated bowler "No balls"
            $this->updateRuns(1, 'No Ball');

        } else {
            $this->updateRuns(1, 'Wide Ball');

            // update bowler "Wide balls"
        }
    }

    /**
     * @param array $probableBalls
     * @param $ball
     * @return bool
     */
    private function isExtrasOrWicket(array $probableBalls, $ball)
    {
        if ($this->isNoOrWideBall($probableBalls, $ball)) {
//                        $probableRuns = 1;
            // update batting team runs
            $this->isExtras($probableBalls, $ball);
            $this->isDelivery = false;
            return false;
        } else {
            $this->updateRuns(0, $ball);
//                        $probableRuns = 0;
            // Remove current batsman
            // Bring new batsman
            // update batsman status
            // update bowler wickets
            $this->isDelivery = true;
            return true;
        }
    }

    /**
     * @param array $probableBalls
     * @param $ball
     * @param array $probableRuns
     * @return mixed
     */
    private function isValidOrInvalidDelivery(array $probableBalls, $ball, array $probableRuns)
    {
        if ($this->isNotDelivery($probableBalls, $ball)) {
            $ball = $this->isExtrasOrWicket($probableBalls, $ball);
        } else {
            $this->isDelivery = true;

            $run = array_rand($probableRuns, 1);

            $this->updateRuns($probableRuns[$run], 'Delivery');

            if ($probableRuns[$run] !== 0) {
                if ($this->isOdd($probableRuns, $run)) {
                    // switch batsmen
                    $temp = $this->batsmanOnStrike;
                    $this->batsmanOnStrike = $this->batsmanOffStrike;
                    $this->batsmanOffStrike = $temp;
                }
            }

        }

        return $ball;
    }

    /**
     * @param $runs
     * @param $type
     */
    private function updateRuns($runs, $type)
    {
        if ($type === 'Delivery') {
            $this->updateBatsmanScorecard($runs);
            $this->updateBowlerRunsForValidDelivery($runs);
        } else {
            $this->updateBowlerRunsForNonDelivery($runs, $type);
        }
    }

    /**
     * @param $runs
     */
    private function updateBatsmanScorecard($runs): void
    {
        $this->batsmanOnStrike->scorecard->batting_runs += $runs;
        $this->batsmanOnStrike->scorecard->batting_balls++;

        $this->batsmanOnStrike->scorecard->strike_rate = $this->batsmanOnStrike->scorecard->batting_runs / $this->batsmanOnStrike->scorecard->batting_balls * 100;

        if ($runs === 4) {
            $this->batsmanOnStrike->scorecard->batting_fours++;
        }

        if ($runs === 6) {
            $this->batsmanOnStrike->scorecard->batting_sixes++;
        }

        $this->batsmanOnStrike->scorecard->update();
    }

    /**
     * @param $runs
     * @param $type
     */
    private function updateBowlerRunsForNonDelivery($runs, $type): void
    {
        if ($type === 'Bowled' || $type === 'Catch out') {
            $this->currentBowler->scorecard->bowling_wickets++;
        }

        if ($type === 'No Ball') {
            $this->currentBowler->scorecard->bowling_runs += $runs;
            $this->currentBowler->scorecard->no_balls += $runs;
        }

        if ($type === 'Catch out') {
            $this->currentBowler->scorecard->bowling_runs += $runs;
            $this->currentBowler->scorecard->wide_balls += $runs;
        }

        $this->currentBowler->scorecard->update();
    }

    /**
     * @param $runs
     */
    private function updateBowlerRunsForValidDelivery($runs): void
    {
// TODO:: calculate bowling overs
        $this->currentBowler->scorecard->bowling_runs += $runs;

        if ($runs === 4) {
            $this->currentBowler->scorecard->bowling_fours++;
        }

        if ($runs === 6) {
            $this->currentBowler->scorecard->bowling_sixes++;
        }

        $this->currentBowler->scorecard->update();
    }

    private function updateBowler($over)
    {
        if ($over % 4 === 0) {
            $this->currentBowler = $this->awayTeamBowlers[4];
        } else {
            $this->currentBowler = $this->awayTeamBowlers[mt_rand(4,8)];
        }

    }
}
