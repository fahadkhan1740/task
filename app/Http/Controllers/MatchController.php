<?php

namespace App\Http\Controllers;

use App\Events\MatchStartedEvent;
use App\Models\Match;
use App\Repositories\MatchRepository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MatchController extends Controller
{
    /**
     * @var MatchRepository
     */
    private $matchRepository;

    /**
     * MatchController constructor.
     * @param MatchRepository $matchRepository
     */
    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    /**
     * Fetch all the matches in a League
     * @return Match[]|Collection
     */
    public function index()
    {
        return Match::with('homeTeam')->with('awayTeam')->get();
    }

    /**
     * Start a match | Create a scorecard
     * @return ResponseFactory|Response
     */
    public function create()
    {
        $match = Match::find(request()->match_id);

        $this->matchRepository->startMatch($match);

        // Increment League table with matches played || Event: Match started
        // 1 - Listener: increase matches played
        event(new MatchStartedEvent($match));

        // 2 - Listener: starts the game

        return response('Match started successfully', 200);
    }
}
