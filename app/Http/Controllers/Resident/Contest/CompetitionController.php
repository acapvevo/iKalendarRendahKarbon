<?php

namespace App\Http\Controllers\Resident\Contest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompetitionController extends Controller
{
    public function list()
    {
        return view('resident.contest.competition.list');
    }
}
