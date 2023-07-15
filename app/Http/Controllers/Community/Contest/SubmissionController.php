<?php

namespace App\Http\Controllers\Community\Contest;

use App\Models\Submission;
use Illuminate\Http\Request;
use App\Traits\CompetitionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    use CompetitionTrait;

    public function list(Request $request)
    {
        $request->validate([
            'competition_id' => 'required|integer|exists:competitions,id'
        ]);

        $community = Auth::user();

        $submission = Submission::where('competition_id', $request->competition_id)->where('community_id', $community->id)->first() ?? new Submission([
            'competition_id' => $request->competition_id,
            'community_id' => $community->id
        ]);

        return view('community.contest.submission.list')->with([
            'submission' => $submission
        ]);
    }
}
