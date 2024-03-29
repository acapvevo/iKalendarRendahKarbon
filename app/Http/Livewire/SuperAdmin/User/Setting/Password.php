<?php

namespace App\Http\Livewire\SuperAdmin\User\Setting;

use Livewire\Component;
use App\Models\SuperAdmin;
use App\Traits\Livewire\CheckGuard;
use Illuminate\Support\Facades\Hash;

class Password extends Component
{
    use CheckGuard;

    protected $guard = 'super_admin';

    public $password;
    public $password_confirmation;

    public SuperAdmin $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    protected function rules()
    {
        return [
            'password' => 'required|string|confirmed|min:8',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $request = $this->validate();

        $this->user->password = Hash::make($request['password']);

        $this->user->save();

        return redirect(route('super_admin.user.setting.view'))->with('success', 'Your Password have been updated successfully');
    }


    public function render()
    {
        return view('livewire.super_admin.user.setting.password');
    }
}
