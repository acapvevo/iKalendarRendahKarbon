<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function view()
    {
        $user = Auth::guard('admin')->user();

        return view('admin.user.profile')->with('user', $user);
    }

    public function update(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'nama' => 'required|string',
            'email' => [
                'required',
                'email',
                'string',
                Rule::unique('admins')->ignore($user->id),
            ]
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;

        $user->save();

        return redirect(route('admin.user.profile.view'))->with('success', 'Profile anda berjaya Dikemaskini');
    }
}
