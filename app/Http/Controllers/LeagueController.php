<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Repositories\LeagueRepository;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    /**
     * @var LeagueRepository
     */
    private $leagueRepository;

    /**
     * LeagueController constructor.
     * @param LeagueRepository $leagueRepository
     */
    public function __construct(LeagueRepository $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * Create a league with all the fixtures
     * @return mixed
     */
    public function create()
    {
        // get all teams
        $teams = Team::all()->toArray();
        // arrange a round robin format in matches table
        $this->leagueRepository->setFixtures($teams);

        return response('Fixtures created successfully', 200);
    }
}
