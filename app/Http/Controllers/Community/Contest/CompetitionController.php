<?php

namespace App\Http\Controllers\Community\Contest;

use App\Models\Competition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompetitionController extends Controller
{
    public function list()
    {
        $competitions = Competition::all()->sortByDesc('year');

        return view('community.contest.competition.list')->with([
            'competitions' => $competitions
        ]);
    }
}
