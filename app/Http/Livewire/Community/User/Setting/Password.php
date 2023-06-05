<?php

namespace App\Http\Livewire\Community\User\Setting;

use Livewire\Component;
use App\Models\Community;
use Illuminate\Support\Facades\Hash;

class Password extends Component
{
    public $password;
    public $password_confirmation;

    public Community $user;

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

        return redirect(route('community.user.setting.view'))->with('success', 'Your Password have been updated successfully');
    }

    public function render()
    {
        return view('livewire.community.user.setting.password');
    }
}
