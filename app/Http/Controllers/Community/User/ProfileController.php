<?php

namespace App\Http\Controllers\Community\User;

use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function view()
    {
        $user = Community::find(Auth::guard('community')->user()->id);

        return view('community.user.profile')->with('user', $user);
    }

    public function ic(Request $request)
    {
        $request->validate([
            'community_id' => 'required|numeric|exists:communities,id'
        ]);

        $user = Community::find($request->community_id);

        return $user->viewIdentificationCard();
    }
}
