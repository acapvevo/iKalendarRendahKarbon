<?php

namespace App\Http\Livewire\SuperAdmin\User\Setting;

use Livewire\Component;
use App\Models\SuperAdmin;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class Picture extends Component
{
    use WithFileUploads;

    public $image;
    public SuperAdmin $user;

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
        $imagePath = "app/profile_picture/super_admin";

        $img = Image::make($request['image']);
        if (!Storage::exists("profile_picture/super_admin")) {
            Storage::makeDirectory("profile_picture/super_admin"); //creates directory
        }
        $img->fit(200)->save(storage_path($imagePath . '/' . $imageName));

        $this->user->image = $imageName;

        $this->user->save();

        redirect(route('super_admin.user.setting.view'))->with('success', 'Your Profile Picture has been updated successfully');
    }

    public function render()
    {
        return view('livewire.super_admin.user.setting.picture');
    }
}
