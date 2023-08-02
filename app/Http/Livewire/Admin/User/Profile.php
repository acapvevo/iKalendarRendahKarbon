<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\Admin;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Traits\Livewire\CheckGuard;

class Profile extends Component
{
    use CheckGuard;

    protected $guard = 'admin';

    public Admin $user;

    protected function rules()
    {
        return [
            'user.name' => 'required|string',
            'user.email' => [
                'required',
                'email',
                'string',
                Rule::unique('admins', 'email')->ignore($this->user->id),
            ]
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $this->validate();

        $this->user->save();

        redirect(route('admin.user.profile.view'))->with('success', 'Your Profile has been updated successfully');
    }

    public function render()
    {
        return view('livewire.admin.user.profile');
    }
}
