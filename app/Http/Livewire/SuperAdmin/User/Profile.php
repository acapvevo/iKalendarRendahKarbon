<?php

namespace App\Http\Livewire\SuperAdmin\User;

use Livewire\Component;
use App\Models\SuperAdmin;
use Illuminate\Validation\Rule;
use App\Traits\Livewire\CheckGuard;

class Profile extends Component
{
    use CheckGuard;

    protected $guard = 'super_admin';

    public SuperAdmin $user;

    protected function rules()
    {
        return [
            'user.name' => 'required|string',
            'user.email' => [
                'required',
                'email',
                'string',
                Rule::unique('super_admins', 'email')->ignore($this->user->id),
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

        redirect(route('super_admin.user.profile.view'))->with('success', 'Your Profile has been updated successfully');
    }

    public function render()
    {
        return view('livewire.super_admin.user.profile');
    }
}
