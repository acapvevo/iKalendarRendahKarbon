<?php

namespace App\Http\Livewire\Admin\User\Setting;

use App\Models\Admin;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class Picture extends Component
{
    use WithFileUploads;

    public $image;
    public Admin $user;

    public function mount($user)
    {
        $this->image = $user->image;
        $this->user = $user;
    }

    protected function rules()
    {
        return [
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $request = $this->validate();

        $imageName = $this->user->id . '.' . $request['image']->extension();
        $imagePath = "app/profile_picture/admin";

        $img = Image::make($request['image']);
        if (!Storage::exists("profile_picture/admin")) {
            Storage::makeDirectory("profile_picture/admin"); //creates directory
        }
        $img->fit(200)->save(storage_path($imagePath . '/' . $imageName));

        $this->user->image = $imageName;

        $this->user->save();

        redirect(route('admin.user.setting.view'))->with('success', 'Your Profile Picture has been updated successfully');
    }

    public function render()
    {
        return view('livewire.admin.user.setting.picture');
    }
}
