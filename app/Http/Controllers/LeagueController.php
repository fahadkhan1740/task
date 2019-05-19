<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\Team;
use App\Repositories\LeagueRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
     * Show League table
     * @return League[]|Builder[]|Collection
     */
    public function index()
    {
        return League::with('team')->orderBy('points', 'DESC')->get();
    }

    /**
     * Create a league with all the fixtures
     * @return mixed
     */
    public function create()
    {
        $teams = Team::all()->toArray();

        // Remove previous fixtures if present
        $this->leagueRepository->resetFixtures();

        // Arrange fixtures
        $this->leagueRepository->setFixtures($teams);

        // Reset League table standings
        $this->leagueRepository->resetStandings($teams);

        return response('Fixtures created successfully', 200);
    }
}
