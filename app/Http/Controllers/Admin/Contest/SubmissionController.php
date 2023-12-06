<?php

namespace App\Http\Controllers\Admin\Contest;

use App\Models\Submission;
use App\Plugins\Datatable;
use Illuminate\Http\Request;
use App\Traits\SubmissionTrait;
use App\Traits\CompetitionTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contest\SelectCompetitionRequest;
use App\Http\Requests\Universal\Submission\DownloadEvidenceRequest;
use App\Http\Requests\Admin\Contest\Submission\ViewSubmissionRequest;
use App\Traits\EvidenceTrait;
use App\Traits\ZoneTrait;

class SubmissionController extends Controller
{
    use CompetitionTrait, EvidenceTrait, SubmissionTrait, ZoneTrait;

    public function list(SelectCompetitionRequest $request)
    {
        $validated = $request->validated();

        $competitions = $this->getCompetitions();

        if (isset($validated['competition_id']))
            $competition = $this->getCompetition($validated['competition_id']);
        else
            $competition = $competitions->get(0);

        return view('admin.contest.submission.list')->with([
            'competitions' => $competitions,
            'currentCompetition' => $competition,
        ]);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'competition_id' => 'required|integer|exists:competitions,id'
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
                'db' => 'zones.number',
                'dt' => 1,
                'as' => 'number',
                // 'formatter' => function ($d, $row) {
                //     if ($d) {
                //         return $this->getZone($d)->getFormalName();
                //     } else {
                //         return '1';
                //     }
                // },
                'title' => __('Zone')
            ),
            array(
                'db' => 'calculations.total_carbon_emission',
                'dt' => 2,
                'as' => 'total_carbon_emission',
                'title' => 'Total Carbon Emission',
                'formatter' => function ($d, $row) {
                    return number_format($d, 2) . ' kgCO<sub>2</sub>';
                },
            ),
            array(
                'db' => 'status',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    $submission = Submission::find($row->id);
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
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    $viewSubmissionTitle = __('View Submission');

                    $viewRecordAndAnswerTitle = __('View Record and Answer');
                    $route = route('admin.contest.submission.view');
                    $csrf_field = csrf_field();

                    return <<< EOT
                    <div class="btn-toolbar justify-content-center" role="toolbar"
                        aria-label="Toolbar with button groups">
                        <div class="btn-group" role="group" aria-label="Action Button">
                            <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                data-bs-target="#viewSubmissionModal"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$viewSubmissionTitle"
                                    data-feather="eye"></i>
                            </button>
                        </div>
                        <div class="ps-3 btn-group" role="group" aria-label="Question">
                            <form action="$route" method="post">
                                $csrf_field

                                <button type="submit" data-bs-toggle="tooltip"
                                    data-bs-title="$viewRecordAndAnswerTitle" class="btn btn-primary btn-sm"
                                    value="$row->id" name="id"><i
                                        class="fa-solid fa-file-lines"></i></button>
                            </form>
                        </div>
                    </div>
                    EOT;
                },
                'as' => 'menu',
                'inFilter' => false,
            ),
        );

        $dbObj = DB::table('submissions')
            ->join('communities', 'submissions.community_id', '=', 'communities.id')
            ->join('addresses', 'addresses.community_id', '=', 'communities.id')
            ->join('calculations', 'calculations.parent_id', '=', 'submissions.id')
            ->leftJoin('zones', 'addresses.zone_id', '=', 'zones.id')
            ->where('submissions.competition_id', '=', $request->competition_id)
            ->where('calculations.parent_type', '=', 'App\Models\Submission')
            ->select([
                'communities.name',
                'communities.username',
                'zones.number',
                'submissions.id',
                'calculations.total_carbon_emission',
            ]);

        return response()->json(Datatable::simple($request->all(), $dbObj, $columns));
    }

    public function view(ViewSubmissionRequest $request)
    {
        $validated = $request->validated();

        $submission = $this->getSubmission($validated['id']);

        return view('admin.contest.submission.view')->with([
            'submission' => $submission,
        ]);
    }

    public function download(DownloadEvidenceRequest $request)
    {
        $validated = $request->validated();

        $evidence = $this->getEvidence($validated['evidence_id']);

        return $evidence->downloadFile();
    }
}
