<?php


namespace App\Repositories;


class ScorecardRepository
{
    /**
     * @param $scorecards
     * @param $homeTeamId
     * @param $awayTeamId
     * @return mixed
     */
    public function filterBatsmen($scorecards, $homeTeamId, $awayTeamId)
    {
        $batsmen = $scorecards->filter(function ($item) use ($homeTeamId, $awayTeamId) {
            if ($item->player->type === 'batsmen' && $item->player->team_id === $homeTeamId) {
                return $item;
            }
        });
        return $batsmen->toArray();
    }

    /**
     * @param $scorecards
     * @param $homeTeamId
     * @param $awayTeamId
     * @return mixed
     */
    public function filterBowlers($scorecards, $homeTeamId, $awayTeamId)
    {
        $bowlers = $scorecards->filter(function ($item) use ($homeTeamId, $awayTeamId) {
            if ($item->player->type === 'bowler' && $item->player->team_id === $awayTeamId) {
                return $item;
            }
        });
        return $bowlers->toArray();
    }
}
