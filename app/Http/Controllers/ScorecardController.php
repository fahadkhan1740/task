<?php

namespace App\Http\Controllers;

use App\Models\Scorecard;
use App\Repositories\ScorecardRepository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScorecardController extends Controller
{
    /**
     * @var ScorecardRepository
     */
    private $scorecardRepository;

    public function __construct(ScorecardRepository $scorecardRepository)
    {
        $this->scorecardRepository = $scorecardRepository;
    }

    public function index()
    {
        return view('scorecard');
    }

    /**
     * @param $matchId
     * @return ResponseFactory|Response
     */
    public function getScorecard()
    {
        $scorecards = Scorecard::with('player')->where('match_id', request()->matchId)->get();

        $homeTeamId = $scorecards[0]->player->team_id;
        $awayTeamId = $scorecards[$scorecards->count() - 1]->player->team_id;

        $homeBatsmen = $this->scorecardRepository->filterBatsmen($scorecards, $homeTeamId, $awayTeamId);
        $homeBowlers = $this->scorecardRepository->filterBowlers($scorecards, $homeTeamId, $awayTeamId);

        $homeNoBalls = 0;
        $homeWideBalls = 0;
        list($homeNoBalls, $homeWideBalls) = $this->countExtras($homeBowlers, $homeNoBalls, $homeWideBalls);

        $awayBatsmen = $this->scorecardRepository->filterBatsmen($scorecards, $awayTeamId, $homeTeamId);
        $awayBowlers = $this->scorecardRepository->filterBowlers($scorecards, $awayTeamId, $homeTeamId);

        $awayNoBalls = 0;
        $awayWideBalls = 0;
        list($awayNoBalls, $awayWideBalls) = $this->countExtras($awayBowlers, $awayNoBalls, $awayWideBalls);

        return \response([
            'home' => [
                'home_batsmen' => $homeBatsmen,
                'home_bowlers' => $homeBowlers,
                'home_extras' => [
                    'no_balls' => $homeNoBalls,
                    'wide_balls' => $homeWideBalls
                ]
            ],
            'away' => [
                'away_batsmen' => $awayBatsmen,
                'away_bowlers' => $awayBowlers,
                'away_extras' => [
                    'no_balls' => $awayNoBalls,
                    'wide_balls' => $awayWideBalls
                ]
            ]
        ], 200);
    }

    /**
     * @param $bowlers
     * @param $noBalls
     * @param $wideBalls
     * @return array
     */
    private function countExtras($bowlers, $noBalls, $wideBalls): array
    {
        foreach ($bowlers as $bowler) {
            $noBalls += $bowler['no_balls'];
            $wideBalls += $bowler['wide_balls'];
        }
        return array($noBalls, $wideBalls);
    }


}
