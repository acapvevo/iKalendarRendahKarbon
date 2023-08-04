<?php

namespace App\Http\Controllers\Admin\Contest;

use App\Http\Controllers\Controller;
use App\Traits\CompetitionTrait;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    use CompetitionTrait;

    public function list()
    {
        $competitions = $this->getCompetitions();

        return view('admin.contest.competition.list')->with([
            'competitions' => $competitions
        ]);
    }
}
