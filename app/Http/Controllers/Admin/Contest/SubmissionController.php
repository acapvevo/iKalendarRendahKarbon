<?php

namespace App\Http\Controllers\Admin\Contest;

use App\Plugins\Datatable;
use Illuminate\Http\Request;
use App\Traits\CompetitionTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Traits\BillTrait;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SubmissionController extends Controller
{
    use CompetitionTrait, BillTrait;

    public function list(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'competition_id' => 'sometimes|numeric|exists:competitions,id'
        ]);

        $competitions = $this->getCompetitions();
        $competition = $this->getCompetition($request->competition_id) ?? $competitions->get(0);

        return view('admin.contest.submission.list')->with([
            'competitions' => $competitions,
            'currentCompetition' => $competition,
            'attributes' => array_diff_key($request->all(), ["_token" => ''])
        ]);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'competition_id' => 'required|integer|exists:competitions,id'
        ]);

        $columns = array(
            array('db' => 'communities.name', 'dt' => 0, 'as' => 'name', 'inFilter' => false),
            array('db' => 'addresses.postcode', 'dt' => 1, 'as' => 'postcode', 'title' => __('Postcode')),
            array(
                'db' => 'submissions.total_carbon_emission',
                'dt' => 2, 'as' => 'total_carbon_emission',
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
            ),
        );

        $dbObj = DB::table('submissions')
            ->join('communities', 'submissions.community_id', '=', 'communities.id')
            ->join('addresses', 'addresses.community_id', '=', 'communities.id')
            ->where('submissions.id', '=', $request->competition_id)
            ->select([
                'communities.name',
                'addresses.postcode',
                'submissions.id',
                'submissions.total_carbon_emission',
            ]);

        return response()->json(Datatable::simple($request->all(), $dbObj, $columns));
    }

    public function view(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:submissions,id'
        ]);

        $submission = Submission::find($request->id);

        return view('admin.contest.submission.view')->with([
            'submission' => $submission,
            'attributes' => array_diff_key($request->all(), ["_token" => ''])
        ]);
    }

    public function download(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:electric,water,recycle,used_oil',
            'bill_id' => 'required|numeric|exists:bills,id',
        ]);

        $bill = $this->getBill($request->bill_id);

        return $bill->downloadEvidence($request->type);
    }
}
