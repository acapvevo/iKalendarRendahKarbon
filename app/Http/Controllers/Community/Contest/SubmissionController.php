<?php

namespace App\Http\Controllers\Community\Contest;

use App\Traits\SubmissionTrait;
use App\Traits\CompetitionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Universal\Submission\DownloadEvidenceRequest;
use App\Http\Requests\Community\Contest\Submission\ChooseCategoryRequest;
use App\Http\Requests\Community\Contest\Submission\SelectCompetitionRequest;
use App\Traits\EvidenceTrait;

class SubmissionController extends Controller
{
    use CompetitionTrait, EvidenceTrait, SubmissionTrait;

    public function category(SelectCompetitionRequest $request)
    {
        $validated = $request->validated();

        $competition = $this->getCompetition($validated['competition_id']);
        $submission_category = $this->getSubmissionCategories();

        return view('community.contest.submission.category')->with([
            'competition' => $competition,
            'submission_category' => $submission_category,
        ]);
    }

    public function list(ChooseCategoryRequest $request)
    {
        $validated = $request->validated();

        $community = Auth::user();

        $submission = $this->getSubmissionByCompetitionIDAndCommunityID($validated['competition_id'], $community->id);
        $categoryDescription = $this->getSubmissionCategoryByCode($validated['category'])->description;

        return view('community.contest.submission.list')->with([
            'submission' => $submission,
            'category' => $validated['category'],
            'categoryDescription' => $categoryDescription,
        ]);
    }

    public function download(DownloadEvidenceRequest $request)
    {
        $validated = $request->validated();

        $evidence = $this->getEvidence($validated['evidence_id']);

        return $evidence->downloadFile();
    }
}
