<?php

namespace App\Http\Livewire\Resident\User\Setting;

use Livewire\Component;
use App\Models\Resident;
use App\Traits\Livewire\CheckGuard;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Password extends Component
{
    use CheckGuard;

    protected $guard = 'resident';

    public $password;
    public $password_confirmation;

    public Resident $user;

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

        return redirect(route('resident.user.setting.view'))->with('success', __("alerts.password_update"));
    }

    public function render()
    {
        return view('livewire.resident.user.setting.password');
    }
}
