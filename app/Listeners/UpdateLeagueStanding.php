<?php

namespace App\Listeners;

use App\Events\MatchStartedEvent;
use App\Models\League;
use App\Models\Team;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateLeagueStandingListener
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
        $matchTeamStandings = League::whereIn('team_id', [$event->match->home_team_id, $event->match->away_team_id])->get();

        $matchTeamStandings->map(function ($standing) {
            $standing->matches_played++;
            $standing->update();
        });
    }
}
