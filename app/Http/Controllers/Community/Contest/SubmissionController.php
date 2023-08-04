<?php

namespace App\Http\Controllers\Community\Contest;

use App\Traits\BillTrait;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Traits\SubmissionTrait;
use App\Traits\CompetitionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{
    use CompetitionTrait, BillTrait, SubmissionTrait;

    public function category(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'competition_id' => 'required|integer|exists:competitions,id'
        ]);

        if ($validator->fails()) {
            return redirect(route('community.contest.competition.list'))
                    ->withErrors($validator);
        }

        $competition = $this->getCompetition($request->competition_id);

        return view('community.contest.submission.category')->with([
            'competition' => $competition,
        ]);
    }

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'competition_id' => 'required|integer|exists:competitions,id',
            'category' => 'required|string|exists:submission_category,name'
        ]);

        if ($validator->fails()) {
            return redirect(route('community.contest.competition.list'))
                    ->withErrors($validator);
        }

        $community = Auth::user();

        $submission = $this->getSubmissionByCompetitionIDAndCommunityID((int)$request->competition_id, $community->id);

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
