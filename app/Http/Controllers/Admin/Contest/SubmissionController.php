<?php

namespace App\Http\Controllers\Admin\Contest;

use App\Plugins\Datatable;
use Illuminate\Http\Request;
use App\Traits\CompetitionTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{
    use CompetitionTrait;

    public function list(Request $request)
    {
        $request->validate([
            'competition_id' => 'sometimes|integer|exists:competitions,id'
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

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
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
                'db' => 'menu',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    $title = __('View Competition');

                    return <<< EOT
                    <div class="btn-toolbar justify-content-center" role="toolbar"
                        aria-label="Toolbar with button groups">
                        <div class="btn-group" role="group" aria-label="Action Button">
                            <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                data-bs-target="#viewSubmissionModal" 
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$title"
                                    data-feather="eye"></i>
                            </button>
                        </div>
                    </div>
                    EOT;
                },
                'as' => 'menu',
                'inFilter' => false
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
}
