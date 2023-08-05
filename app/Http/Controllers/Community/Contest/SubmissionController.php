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
use App\Http\Requests\Universal\Submission\DownloadEvidenceRequest;
use App\Http\Requests\Community\Contest\Submission\ChooseCategoryRequest;
use App\Http\Requests\Community\Contest\Submission\SelectCompetitionRequest;

class SubmissionController extends Controller
{
    use CompetitionTrait, BillTrait, SubmissionTrait;

    public function category(SelectCompetitionRequest $request)
    {
        $validated = $request->validated();

        $competition = $this->getCompetition($validated['competition_id']);

        return view('community.contest.submission.category')->with([
            'competition' => $competition,
        ]);
    }

    public function list(ChooseCategoryRequest $request)
    {
        $validated = $request->validated();

        $community = Auth::user();

        $submission = $this->getSubmissionByCompetitionIDAndCommunityID($validated['competition_id'], $community->id);

        switch ($validated['category']) {
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

    public function download(DownloadEvidenceRequest $request)
    {
        $validated = $request->validated();

        $bill = $this->getBill($validated['bill_id']);

        return $bill->downloadEvidence($validated['type']);
    }
}
