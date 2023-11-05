<?php

namespace App\Http\Controllers\Resident\User;

use Illuminate\Http\Request;
use App\Traits\ResidentTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ResidentTrait;

    public function view()
    {
        $user = $this->getResident(Auth::guard('resident')->user()->id);

        return view('resident.user.profile')->with('user', $user);
    }
}
