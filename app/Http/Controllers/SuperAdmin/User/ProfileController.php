<?php

namespace App\Http\Controllers\SuperAdmin\User;

use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function view()
    {
        $user = SuperAdmin::find(Auth::guard('super_admin')->user()->id);

        return view('super_admin.user.profile')->with('user', $user);
    }
}
