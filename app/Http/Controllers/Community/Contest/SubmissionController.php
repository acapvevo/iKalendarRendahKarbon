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

    public function category(Request $request)
    {
        $request->validate([
            'competition_id' => 'required|integer|exists:competitions,id'
        ]);

        $competition = $this->getCompetition($request->competition_id);

        return view('community.contest.submission.category')->with([
            'competition' => $competition,
            'attributes' => array_diff_key($request->all(), ["_token" => ''])
        ]);
    }

    public function list(Request $request)
    {
        $request->validate([
            'competition_id' => 'required|integer|exists:competitions,id',
            'category' => 'required|string|exists:submission_category,name'
        ]);

        $community = Auth::user();

        $submission = Submission::where('competition_id', $request->competition_id)->where('community_id', $community->id)->first() ?? new Submission([
            'competition_id' => (int)$request->competition_id,
            'community_id' => $community->id
        ]);

        switch ($request->category) {
            case 'electric':
                $categoryName = __('Electric');
                break;

            case 'water':
                $categoryName = __('Water');
                break;

            case 'recycle':
                $categoryName = __('Recycle');
                break;

            case 'used_oil':
                $categoryName = __('Used Oil');
                break;

            default:
                $categoryName = 'Default';
                break;
        }

        return view('community.contest.submission.list')->with([
            'submission' => $submission,
            'category' => $request->category,
            'categoryName' => $categoryName,
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

        return $bill->downloadEvidence($request->type);
    }
}
