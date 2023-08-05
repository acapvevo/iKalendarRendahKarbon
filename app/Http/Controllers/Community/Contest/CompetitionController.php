<?php

namespace App\Http\Controllers\Community\Contest;

use App\Models\Competition;
use App\Traits\CompetitionTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompetitionController extends Controller
{
    use CompetitionTrait;

    public function list()
    {
        $competitions = $this->getCompetitions();

        return view('community.contest.competition.list')->with([
            'competitions' => $competitions
        ]);
    }
}
