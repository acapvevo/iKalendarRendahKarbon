<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function view()
    {
        $user = Admin::find(Auth::guard('admin')->user()->id);

        return view('admin.user.profile')->with('user', $user);
    }
}
