<?php

namespace App\Http\Controllers\Admin\Analysis;

use Illuminate\Http\Request;
use App\Traits\CompetitionTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contest\SelectCompetitionRequest;

class OverallController extends Controller
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

        return view('admin.analysis.overall.view')->with([
            'competitions' => $competitions,
            'currentCompetition' => $competition,
        ]);
    }
}
