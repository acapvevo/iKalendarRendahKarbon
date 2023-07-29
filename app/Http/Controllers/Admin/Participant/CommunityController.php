<?php

namespace App\Http\Controllers\Admin\Participant;

use App\Models\Community;
use App\Plugins\Datatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CommunityController extends Controller
{
    public function list()
    {
        return view('admin.participant.community.list');
    }

    public function filter(Request $request)
    {
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
            array('db' => 'addresses.postcode', 'dt' => 1, 'as' => 'postcode', 'title' => __('Postcode')),
            array(
                'db' => 'communities.isVerified',
                'dt' => 2,
                'formatter' => function ($d, $row) {

                    switch ($d) {
                        case true:
                            $type = 'success';
                            $text = 'Verified';
                            break;
                        case false:
                            $type = 'danger';
                            $text = 'Not Verified';
                            break;
                        default:
                            $type = 'primary';
                            $text = '';
                            break;
                    }

                    return <<< EOT
                    <span class="badge text-bg-$type">$text</span>
                    EOT;
                },
                'as' => 'isVerified',
                'title' => __('Status')
            ),
            array(
                'db' => 'menu',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    $viewCommunityTitle = __('View Community');
                    $editCommunityTitle = __('Edit Community');

                    return <<< EOT
                    <div class="btn-toolbar justify-content-center" role="toolbar"
                        aria-label="Toolbar with button groups">
                        <div class="btn-group" role="group" aria-label="Action Button">
                            <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                data-bs-target="#viewCommunityModal"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$viewCommunityTitle"
                                    data-feather="eye"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                data-bs-target="#editCommunityModal"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$editCommunityTitle"
                                    data-feather="edit-2"></i>
                            </button>
                        </div>
                    </div>
                    EOT;
                },
                'as' => 'menu',
                'inFilter' => false
            ),
        );

        $dbObj = DB::table('communities')
            ->join('addresses', 'addresses.community_id', '=', 'communities.id')
            ->select([
                'communities.id',
                'communities.name',
                'communities.username',
                'communities.isVerified',
                'addresses.postcode',
            ]);

        return response()->json(Datatable::simple($request->all(), $dbObj, $columns));
    }
}
