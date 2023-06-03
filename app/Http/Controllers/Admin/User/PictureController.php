<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    public function show()
    {
        $user = Admin::find(Auth::guard('admin')->user()->id);

        return Storage::response('profile_picture/admin/' . $user->image);
    }
}
