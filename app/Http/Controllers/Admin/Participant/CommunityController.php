<?php

namespace App\Http\Controllers\Admin\Participant;

use App\Models\Community;
use App\Plugins\Datatable;
use Illuminate\Http\Request;
use App\Traits\CommunityTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Universal\Participant\Community\ViewIdentificationCardRequest;
use App\Http\Requests\Universal\Participant\Community\ViewProfileRequest;
use App\Traits\ResidentTrait;

class CommunityController extends Controller
{
    use CommunityTrait, ResidentTrait;

    public function list(Request $request)
    {
        $request->validate([
            'resident_id' => 'nullable|numeric|exists:residents,id'
        ]);

        $resident = $this->getResident($request->resident_id);

        return view('admin.participant.community.list')->with([
            'resident' => $resident
        ]);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'resident_id' => 'nullable|numeric|exists:residents,id'
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
            array('db' => 'communities.email', 'dt' => 1, 'as' => 'email', 'title' => __('Email Address')),
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
                    $viewCommunityTitle = __('View Resident');
                    $editCommunityTitle = __('Edit Resident');
                    $verifyCommunityTitle = __('Verify Resident');

                    $verifyCommunityButton = (!$row->isVerified && $row->identification_card_image) ? <<< EOT
                    <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                        data-bs-target="#verifyCommunityModal"
                        id="$row->id">
                        <i data-bs-toggle="tooltip" data-bs-title="$verifyCommunityTitle"
                            data-feather="user-check"></i>
                    </button>
                    EOT : '';

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
                            $verifyCommunityButton
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
                            $verifyCommunityButton
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

        $dbObj = DB::table('communities')
            ->select([
                'communities.id',
                'communities.name',
                'communities.username',
                'communities.email',
                'communities.isVerified',
                'communities.identification_card_image',
            ]);

        if ($request->has('resident_id'))
            $dbObj->where('resident_id', $request->resident_id);

        return response()->json(Datatable::simple($request->all(), $dbObj, $columns));
    }

    public function select(Request $request)
    {
        $request->validate([
            'resident_id' => 'nullable|numeric|exists:residents,id',
            'term' => 'required|string|max:255'
        ]);

        $communities = $this->searchCommunities($request->term, $request->resident_id);

        return response()->json([
            "results" => $communities->items(),
            "pagination" => [
                "more" => $communities->hasMorePages()
            ]
        ]);
    }

    public function ic(ViewProfileRequest $request)
    {
        $validated = $request->validated();

        $community = $this->getCommunity($validated['community_id']);

        return $community->viewIdentificationCard();
    }

    public function picture(ViewProfileRequest $request)
    {
        $validated = $request->validated();

        $community = $this->getCommunity($validated['community_id']);

        return $community->viewProfilePicture();
    }
}
