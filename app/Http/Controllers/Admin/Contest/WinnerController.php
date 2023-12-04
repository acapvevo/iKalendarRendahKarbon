<?php

namespace App\Http\Controllers\Admin\Contest;

use App\Exports\WinnerListExport;
use App\Plugins\Datatable;
use App\Traits\CompetitionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contest\SelectCompetitionRequest;
use App\Http\Requests\Universal\Submission\ViewSubmissionRequest;
use App\Traits\SubmissionTrait;

class WinnerController extends Controller
{
    use CompetitionTrait, SubmissionTrait;

    public function list(SelectCompetitionRequest $request)
    {
        $validated = $request->validated();

        $competitions = $this->getCompetitions();

        if (isset($validated['competition_id']))
            $competition = $this->getCompetition($validated['competition_id']);
        else
            $competition = $competitions->get(0);

        return view('admin.contest.winner.list')->with([
            'competitions' => $competitions,
            'currentCompetition' => $competition,
        ]);
    }

    public function recalculate($year)
    {
        $competition = $this->getCompetitionByYear($year);

        foreach($competition->submissions as $submission){
            $submission->calculateStats();
        }

        return response()->json([
            'message' => 'ok'
        ]);
    }

    public function export(SelectCompetitionRequest $request)
    {
        $validated = $request->validated();

        $competitions = $this->getCompetitions();

        if (isset($validated['competition_id']))
            $competition = $this->getCompetition($validated['competition_id']);
        else
            $competition = $competitions->get(0);

        return (new WinnerListExport($competition))->download(__('Winner_Result_') . $competition->year . '.xlsx');
    }

    public function view(ViewSubmissionRequest $request)
    {
        $validated = $request->validated();
        $submission = $this->getSubmission($validated['submission_id']);

        return view('admin.contest.winner.view')->with([
            'submission' => $submission
        ]);
    }
}
