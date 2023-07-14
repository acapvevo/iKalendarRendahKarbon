<?php

namespace App\Http\Controllers\Admin\Contest;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function list()
    {
        $competitions = Competition::all()->sortByDesc('year');

        return view('admin.contest.competition.list')->with([
            'competitions' => $competitions
        ]);
    }
}
