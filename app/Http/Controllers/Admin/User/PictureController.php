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
    public function update(Request $request)
    {
        $user = Admin::find(Auth::guard('admin')->user()->id);

        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $imageName = $user->id . '.' . $request->image->extension();
        $imagePath = "app/profile_picture/admin";

        $img = Image::make($request->image);
        if (!Storage::exists("profile_picture/admin")) {
            Storage::makeDirectory("profile_picture/admin"); //creates directory
        }
        $img->fit(200)->save(storage_path($imagePath . '/' . $imageName));

        $user->image = $imageName;
        $user->save();

        return redirect(route('admin.user.setting.view'))->with('success', 'Your Profile Picture was updated successfully');
    }

    public function show()
    {
        $user = Admin::find(Auth::guard('admin')->user()->id);

        return Storage::response('profile_picture/admin/' . $user->image);
    }
}
