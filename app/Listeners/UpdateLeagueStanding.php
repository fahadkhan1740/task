<?php

namespace App\Listeners;

use App\Events\MatchStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateLeagueStanding
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
     * @param  MatchStarted  $event
     * @return void
     */
    public function handle(MatchStarted $event)
    {
        //
    }
}
