<?php

namespace App\Http\Livewire\Community\Auth;

use App\Models\Address;
use Livewire\Component;
use App\Models\Community;
use App\Models\Occupation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Notifications\VerifyEmail;

class Register extends Component
{
    public Community $user;

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
        $this->user = new Community;
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

        Auth::guard('community')->login($community = Community::create([
            'username' => $this->user->username,
            'email' => $this->user->email,
            'password' => Hash::make($this->user->password),
        ]));

        Occupation::create([
            'community_id' => $community->id,
        ]);

        Address::create([
            'community_id' => $community->id,
            'state' => 'JOHOR',
            'country' => 'MALAYSIA',
        ]);

        VerifyEmail::createUrlUsing(function ($notifiable) {
            return URL::temporarySignedRoute(
                'community.verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        });

        event(new Registered($community));

        return redirect(route('community.dashboard'));
    }

    public function render()
    {
        return view('livewire.community.auth.register');
    }
}
