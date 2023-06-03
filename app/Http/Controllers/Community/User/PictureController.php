<?php

namespace App\Http\Controllers\Community\User;

use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    public function show()
    {
        $user = Community::find(Auth::guard('community')->user()->id);

        return Storage::response('profile_picture/community/' . $user->image);
    }
}
