<?php

namespace App\Listeners;

use App\Events\MatchStartedEvent;
use App\Models\Match;
use App\Models\Team;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class MatchProgressListener
{
    private $over;
    private $match;
    private $isDelivery;
    private $battingTeam;
    private $bowlingTeam;
    private $doUpdateOver;
    private $currentBowler;
    private $homeTeamBatsmen;
    private $batsmanOnStrike;
    private $batsmanOffStrike;
    private $awayTeamBowlers;
    private $isHomeMatch;

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
        $this->match = Match::find($event->match->id);

        $homeTeam = Team::with('players.scorecard')
                    ->with('league')
                    ->with('league.matches')
                    ->find($event->match->home_team_id);

        $awayTeam = Team::with('players.scorecard')
                    ->with('league')
                    ->with('league.matches')
                    ->find($event->match->away_team_id);


        $this->isHomeMatch = true;

        $this->inning($homeTeam, $awayTeam);

        $this->isHomeMatch = false;

        $this->inning($awayTeam, $homeTeam);
    }

    /**
     * @param $homeTeam
     * @param $awayTeam
     */
    private function inning($homeTeam, $awayTeam): void
    {
        $this->battingTeam = $homeTeam;
        $this->bowlingTeam = $awayTeam;

        $this->homeTeamBatsmen = $homeTeam->players->filter(function ($player) {
            return $player->type === 'batsmen';
        });

        $this->awayTeamBowlers = $awayTeam->players->filter(function ($player) {
            return $player->type === 'bowler';
        });

        $this->batsmanOnStrike = $this->homeTeamBatsmen[0];
        $this->batsmanOffStrike = $this->homeTeamBatsmen[1];

        $this->currentBowler = $this->awayTeamBowlers[4];

        // update scorecards every 5 seconds by firing events

        // one bowler | two batsmen: status => not out, rest_status => empty

        $probableRuns = [0, 1, 2, 3, 4, 6];
        $probableBalls = ['No Ball', 'Wide Ball', 'Bowled', 'Catch out', 'Delivery'];

        $totalBalls = env('OVERS') * 6;

        for ($this->over = 0; $this->over < env('OVERS'); $this->over++) {
            $this->doUpdateOver = false;

            for ($ball = 0; $ball < 6;) {
                $this->isDelivery = false;

                $balled = array_rand($probableBalls, 1);

                $this->isValidOrInvalidDelivery($probableBalls, $balled, $probableRuns);

                if ($this->isDelivery) {
                    $ball++;
                }
            }

            $this->doUpdateOver = true;
            $this->updateBowler($this->over);
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

        $this->updateTeamRuns($runs, $type);
    }

    /**
     * @param $runs
     */
    private function updateBatsmanScorecard($runs): void
    {
        Log::debug('batting runs '. $runs);
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
            $randomBowlerIndex = array_rand($this->awayTeamBowlers->toArray(), 1);
            $this->currentBowler = $this->awayTeamBowlers[$randomBowlerIndex];
        }
    }

    private function updateTeamRuns($runs, string $type)
    {
        Log::debug($this->over);

        if ($this->isHomeMatch) {
            if ($this->over === env('OVERS')) {
                return;
            }

            if ($runs > 0) {
                $this->match->home_team_runs += $runs;
                \Log::info("Runs". $runs ." Home team runs ". $this->match->home_team_runs);
            }

            if ($this->over === 0) {
                $this->match->home_team_overs = 1;
            } else {
                $this->match->home_team_overs = $this->over;
            }

            $this->match->home_team_run_rate = $this->match->home_team_runs / $this->match->home_team_overs;
        } else {
            if ($this->over === env('OVERS')) {
                return;
            }

            if ($runs > 0) {
                $this->match->away_team_runs += $runs;
                \Log::info("Runs". $runs ." Home team runs ". $this->match->away_team_runs);
            }

            if ($this->over === 0) {
                $this->match->away_team_overs = 1;
            } else {
                $this->match->away_team_overs = $this->over;
            }

            $this->match->away_team_run_rate = $this->match->away_team_runs / $this->match->away_team_overs;
        }

        $this->match->update();
    }


}
