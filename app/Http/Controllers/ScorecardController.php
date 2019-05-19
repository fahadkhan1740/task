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

    /**
     * @param $matchId
     * @return ResponseFactory|Response
     */
    public function getScorecard($matchId)
    {
        $scorecards = Scorecard::with('player')->where('match_id', $matchId)->get();

        $homeTeamId = $scorecards[0]->player->team_id;
        $awayTeamId = $scorecards[$scorecards->count() - 1]->player->team_id;

        $batsmen = $this->scorecardRepository->filterBatsmen($scorecards, $homeTeamId, $awayTeamId);

        $bowlers = $this->scorecardRepository->filterBowlers($scorecards, $homeTeamId, $awayTeamId);

        $noBalls = 0;
        $wideBalls = 0;
        list($noBalls, $wideBalls) = $this->countExtras($bowlers, $noBalls, $wideBalls);

        return response([
            'batsmen' => $batsmen,
            'bowlers' => $bowlers,
            'extras' => [
                'no_balls' => $noBalls,
                'wide_balls' => $wideBalls
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
