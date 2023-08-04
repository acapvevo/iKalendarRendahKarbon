<?php

namespace App\Http\Controllers\Community\User;

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

    public function ic(Request $request)
    {
        $request->validate([
            'community_id' => 'required|numeric|exists:communities,id'
        ]);

        $user = $this->getCommunity($request->community_id);

        return $user->viewIdentificationCard();
    }
}
