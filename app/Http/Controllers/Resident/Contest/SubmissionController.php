<?php

namespace App\Http\Controllers\Resident\Contest;

use App\Plugins\Datatable;
use Illuminate\Http\Request;
use App\Traits\ResidentTrait;
use App\Traits\CommunityTrait;
use App\Traits\SubmissionTrait;
use App\Traits\CompetitionTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Universal\Submission\ViewSubmissionRequest;
use App\Http\Requests\Universal\Competition\ViewCompetitionRequest;
use App\Http\Requests\Universal\Submission\DownloadEvidenceRequest;
use App\Http\Requests\Resident\Contest\Submission\ChooseCategoryRequest;
use App\Traits\EvidenceTrait;

class SubmissionController extends Controller
{
    use CompetitionTrait, SubmissionTrait, ResidentTrait, CommunityTrait, EvidenceTrait;

    public function list(ViewCompetitionRequest $request)
    {
        $validated = $request->validated();

        $competition = $this->getCompetition($validated['competition_id']);

        return view('resident.contest.submission.list')->with([
            'currentCompetition' => $competition,
        ]);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'competition_id' => 'required|numeric|exists:competitions,id'
        ]);

        $columns = array(
            array(
                'db' => ['communities.name', 'communities.username'],
                'dt' => 0,
                'as' => 'name',
                'formatter' => function ($d, $row) {
                    if ($d) {
                        return $d;
                    } else {
                        return $row->username;
                    }
                }
            ),
            array(
                'db' => 'status',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    $submission = $this->getSubmission($row->id);
                    $text = $submission->checkBillsSubmit();

                    switch ($text) {
                        case __('Fully Submitted'):
                            $type = 'success';
                            break;
                        case __('Partially Submitted'):
                            $type = 'warning';
                            break;
                        case __('Not Submitted'):
                            $type = 'danger';
                            break;
                        default:
                            $type = 'primary';
                            break;
                    }

                    return <<< EOT
                    <span class="badge text-bg-$type">$text</span>
                    EOT;
                },
                'as' => 'status',
                'inFilter' => false
            ),
            array(
                'db' => 'menu',
                'dt' => 2,
                'formatter' => function ($d, $row) {
                    $viewSubmissionTitle = __('View Submission');

                    $viewRecordAndAnswerTitle = __('View Record and Answer');

                    return <<< EOT
                    <div class="justify-content-center">
                        <div class="btn-group-vertical d-lg-none" role="group"
                            aria-label="Vertical button group">
                            <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                data-bs-target="#viewSubmissionModal"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$viewSubmissionTitle"
                                    data-feather="eye"></i>
                            </button>
                            <button type="button" data-bs-toggle="tooltip"
                                data-bs-title="$viewRecordAndAnswerTitle" class="btn btn-primary btn-sm viewSubmission"
                                id="$row->id"><i
                                    data-feather="file-text"></i></button>
                        </div>
                        <div class="btn-group d-none d-lg-inline-flex" role="group"
                            aria-label="Horizontal button group">
                            <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                data-bs-target="#viewSubmissionModal"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$viewSubmissionTitle"
                                    data-feather="eye"></i>
                            </button>
                            <button type="button" data-bs-toggle="tooltip"
                                data-bs-title="$viewRecordAndAnswerTitle" class="btn btn-primary btn-sm viewSubmission"
                                id="$row->id"><i
                                    data-feather="file-text"></i></button>
                        </div>
                    </div>
                    EOT;
                },
                'as' => 'menu',
            ),
        );

        $dbObj = DB::table('submissions')
            ->join('communities', 'submissions.community_id', '=', 'communities.id')
            ->where('communities.resident_id', '=', $this->getCurrentResident()->id)
            ->where('submissions.competition_id', '=', $request->competition_id)
            ->select([
                'communities.name',
                'communities.username',
                'submissions.id',
            ]);

        return response()->json(Datatable::simple($request->all(), $dbObj, $columns));
    }

    public function select(Request $request)
    {
        $request->validate([
            'competition_id' => 'required|numeric|exists:competitions,id',
            'term' => 'required|string|max:255'
        ]);

        $communities = $this->searchCommunitiesWithResidentIDWithoutSubmission($request->term, $this->getCurrentResident()->id, $request->competition_id);

        return response()->json([
            "results" => $communities->items(),
            "pagination" => [
                "more" => $communities->hasMorePages()
            ]
        ]);
    }

    public function category(ViewSubmissionRequest $request)
    {
        $validated = $request->validated();

        $submission = $this->getSubmission($validated['submission_id']);
        $submission_category = $this->getSubmissionCategories();

        return view('resident.contest.submission.category')->with([
            'submission' => $submission,
            'submission_category' => $submission_category,
        ]);
    }

    public function view(ChooseCategoryRequest $request)
    {
        $validated = $request->validated();

        $submission = $this->getSubmission($validated['submission_id']);
        $categoryDescription = $this->getSubmissionCategoryByCode($validated['category'])->description;

        return view('resident.contest.submission.view')->with([
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
