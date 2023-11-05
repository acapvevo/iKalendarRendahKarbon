<?php

namespace App\Http\Controllers\Resident\User;

use Illuminate\Http\Request;
use App\Traits\ResidentTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    use ResidentTrait;

    public function show()
    {
        $user = $this->getResident(Auth::guard('resident')->user()->id);

        return Storage::response('profile_picture/resident/' . $user->image);
    }
}
