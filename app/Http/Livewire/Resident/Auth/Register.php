<?php

namespace App\Http\Livewire\Resident\Auth;

use Livewire\Component;
use App\Models\Resident;
use App\Traits\ResidentTrait;
use App\Traits\Livewire\CheckGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Register extends Component
{
    use ResidentTrait;

    public Resident $user;

    public $captcha;
    public $password;
    public $password_confirmation;

    public $tab_state = 1;
    public $isVisible = false;

    protected $rules = [
        'user.username' => 'required|string|max:255|unique:communities,username',
        'user.email' => 'required|string|email|max:255|unique:communities,email',
        'password' => 'required|string|confirmed|min:8',
    ];

    public function mount()
    {
        $this->user = new Resident;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function nextTab()
    {
        $this->tab_state++;

        $this->emit('changeTab', $this->tab_state);
    }

    public function previousTab()
    {
        $this->tab_state--;

        $this->emit('changeTab', $this->tab_state);
    }

    public function setTab($tab_state)
    {
        $this->tab_state = $tab_state;
    }

    public function toogleVisibility()
    {
        $this->emit('tooglePasswordVisibility', $this->isVisible = !$this->isVisible);
    }

    public function create()
    {
        $this->validate([
            'captcha' => 'recaptcha',
            'user.username' => 'required|string|max:255|unique:communities,username',
            'user.email' => 'required|string|email|max:255|unique:communities,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $resident = $this->createResident([
            'username' => $this->user->username,
            'email' => $this->user->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::guard('resident')->login($resident);

        return redirect(route('resident.dashboard'));
    }

    public function render()
    {
        return view('livewire.resident.auth.register');
    }
}
