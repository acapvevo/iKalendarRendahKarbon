<?php

namespace App\Http\Controllers\Resident\Participant;

use App\Plugins\Datatable;
use Illuminate\Http\Request;
use App\Traits\ResidentTrait;
use App\Traits\CommunityTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Universal\Participant\Community\ViewProfileRequest;

class CommunityController extends Controller
{
    use ResidentTrait, CommunityTrait;

    public function list()
    {
        return view('resident.participant.community.list');
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
            array('db' => 'communities.email', 'dt' => 1, 'as' => 'email', 'title' => __('Email Address')),
            array(
                'db' => 'menu',
                'dt' => 2,
                'formatter' => function ($d, $row) {
                    $viewCommunityTitle = __('View Community');
                    $editCommunityTitle = __('Edit Community');

                    return <<< EOT
                    <div class="justify-content-center">
                        <div class="btn-group-vertical d-lg-none" role="group"
                            aria-label="Vertical button group">
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
                        <div class="btn-group d-none d-lg-inline-flex" role="group"
                            aria-label="Horizontal button group">
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
            ->select([
                'communities.id',
                'communities.name',
                'communities.username',
                'communities.email',
            ])->where([
                'communities.resident_id' => $this->getCurrentResident()->id
            ]);

        return response()->json(Datatable::simple($request->all(), $dbObj, $columns));
    }

    public function select(Request $request)
    {
        $request->validate([
            'term' => 'required|string|max:255'
        ]);

        $communities = $this->searchCommunitiesWithoutResident($request->term);

        return response()->json([
            "results" => $communities->items(),
            "pagination" => [
                "more" => $communities->hasMorePages()
            ]
        ]);
    }

    public function picture(ViewProfileRequest $request)
    {
        $validated = $request->validated();

        $community = $this->getCommunity($validated['community_id']);

        return $community->viewProfilePicture();
    }
}
