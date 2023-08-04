<?php

namespace App\Http\Controllers\Community\User;

use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CommunityTrait;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    use CommunityTrait;

    public function view()
    {
        $user = $this->getCommunity(Auth::guard('community')->user()->id);

        return view('community.user.setting')->with([
            'user' => $user
        ]);
    }
}
