<?php

namespace App\Http\Controllers\Admin\Analysis;

use App\Exports\CompetitionAnaysisExport;
use Illuminate\Http\Request;
use App\Traits\CompetitionTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contest\SelectCompetitionRequest;

class CompetitionController extends Controller
{
    use CompetitionTrait;

    public function view(SelectCompetitionRequest $request)
    {
        $validated = $request->validated();

        $competitions = $this->getCompetitions();

        if (isset($validated['competition_id']))
            $competition = $this->getCompetition($validated['competition_id']);
        else
            $competition = $competitions->get(0);

        return view('admin.analysis.competition.view')->with([
            'currentCompetition' => $competition,
            'competitions' => $competitions,
        ]);
    }

    public function export(SelectCompetitionRequest $request)
    {
        $validated = $request->validated();

        if (isset($validated['competition_id']))
            $competition = $this->getCompetition($validated['competition_id']);
        else
            $competition = $this->getCompetitions()->get(0);

        return (new CompetitionAnaysisExport($competition))->download('iKalendar_' . $competition->year . '_Analysis.xlsx');
    }
}
