<?php

namespace App\Http\Livewire\Resident\User\Setting;

use Livewire\Component;
use App\Models\Resident;
use Livewire\WithFileUploads;
use App\Traits\Livewire\CheckGuard;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Picture extends Component
{
    use WithFileUploads, CheckGuard;

    protected $guard = 'resident';

    public $image;
    public Resident $user;

    public function mount($user)
    {
        $this->image = $user->image;
        $this->user = $user;
    }

    protected function rules()
    {
        return [
            'image' => 'required|image|max:2048'
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
        $imagePath = "app/profile_picture/resident";

        $img = Image::make($request['image']);
        if (!Storage::exists("profile_picture/resident")) {
            Storage::makeDirectory("profile_picture/resident"); //creates directory
        }
        $img->fit(200)->save(storage_path($imagePath . '/' . $imageName));

        $this->user->image = $imageName;

        $this->user->save();

        redirect(route('resident.user.setting.view'))->with('success', __('alerts.picture_update'));
    }

    public function render()
    {
        return view('livewire.resident.user.setting.picture');
    }
}
