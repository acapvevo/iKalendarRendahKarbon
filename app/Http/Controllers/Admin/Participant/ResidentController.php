<?php

namespace App\Http\Controllers\Admin\Participant;

use App\Plugins\Datatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResidentController extends Controller
{
    public function list()
    {
        return view('admin.participant.resident.list');
    }

    public function filter(Request $request)
    {
        $columns = array(
            array(
                'db' => ['residents.name', 'residents.username'],
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
            array('db' => 'residents.email', 'dt' => 1, 'as' => 'email', 'title' => __('Email Address')),
            array(
                'db' => 'menu',
                'dt' => 2,
                'formatter' => function ($d, $row) {
                    $viewResidentTitle = __('View Community');
                    $editResidentTitle = __('Edit Community');
                    $viewCommunityTitle = __('View Residents');

                    return <<< EOT
                    <div class="justify-content-center">
                        <div class="btn-group-vertical d-lg-none" role="group"
                            aria-label="Vertical button group">
                            <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                data-bs-target="#viewResidentModal"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$viewResidentTitle"
                                    data-feather="eye"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                data-bs-target="#editResidentModal"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$editResidentTitle"
                                    data-feather="edit-2"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm viewCommunity"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$viewCommunityTitle"
                                    data-feather="users"></i>
                            </button>
                        </div>
                        <div class="btn-group d-none d-lg-inline-flex" role="group"
                            aria-label="Horizontal button group">
                            <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                data-bs-target="#viewResidentModal"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$viewResidentTitle"
                                    data-feather="eye"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                data-bs-target="#editResidentModal"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$editResidentTitle"
                                    data-feather="edit-2"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm viewCommunity"
                                id="$row->id">
                                <i data-bs-toggle="tooltip" data-bs-title="$viewCommunityTitle"
                                    data-feather="users"></i>
                            </button>
                        </div>
                        <div class="btn-group" role="group" aria-label="Action Button">
                        </div>
                    </div>
                    EOT;
                },
                'as' => 'menu',
                'inFilter' => false
            ),
        );

        $dbObj = DB::table('residents')
            ->select([
                'residents.id',
                'residents.name',
                'residents.username',
                'residents.email',
            ]);

        return response()->json(Datatable::simple($request->all(), $dbObj, $columns));
    }
}
