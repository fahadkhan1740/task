<?php

namespace App\Providers;

use App\Events\MatchStartedEvent;
use App\Listeners\MatchProgressListener;
use App\Listeners\UpdateLeagueStanding;
use App\Listeners\UpdateLeagueStandingListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MatchStartedEvent::class => [
            UpdateLeagueStandingListener::class,
            MatchProgressListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
