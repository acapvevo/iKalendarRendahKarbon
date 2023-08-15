<?php

namespace App\Http\Controllers\Community\User;

use App\Http\Requests\Universal\Participant\Community\ViewIdentificationCardRequest;
use App\Models\Community;
use App\Traits\CommunityTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use CommunityTrait;

    public function view()
    {
        $user = $this->getCommunity(Auth::guard('community')->user()->id);
        
        return view('community.user.profile')->with('user', $user);
    }

    public function ic(ViewIdentificationCardRequest $request)
    {
        $validated = $request->validated();

        $user = $this->getCommunity($validated['community_id']);

        return $user->viewIdentificationCard();
    }
}
