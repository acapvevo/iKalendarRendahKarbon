<?php

namespace App\Http\Controllers\Community\Contest;

use App\Models\Submission;
use Illuminate\Http\Request;
use App\Traits\CompetitionTrait;
use App\Http\Controllers\Controller;
use App\Traits\BillTrait;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    use CompetitionTrait, BillTrait;

    public function list(Request $request)
    {
        $request->validate([
            'competition_id' => 'required|integer|exists:competitions,id'
        ]);

        $community = Auth::user();

        $submission = Submission::where('competition_id', $request->competition_id)->where('community_id', $community->id)->first() ?? new Submission([
            'competition_id' => (int)$request->competition_id,
            'community_id' => $community->id
        ]);

        return view('community.contest.submission.list')->with([
            'submission' => $submission,
            'attributes' => array_diff_key($request->all(), ["_token" => ''])
        ]);
    }

    public function download(Request $request)
    {
        $request->validate([
            'type' => 'required|in:electric,water,recycle,used_oil',
            'bill_id' => 'required|numeric|exists:bills,id',
        ]);

        $bill = $this->getBill($request->bill_id);

        return response()->file(storage_path('app/evidences/' . $bill->submission->competition->year . '/' . $bill->submission->community_id . '/' . $bill->{$request->type}->evidence));
    }
}
