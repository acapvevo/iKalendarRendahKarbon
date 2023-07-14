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
    public Address $address;
    public Occupation $occupation;
    public $captcha;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'user.username' => 'required|string|max:255|unique:communities,username',
        'user.email' => 'required|string|email|max:255|unique:communities,email',
        'password' => 'required|string|confirmed|min:8',
        'user.name' => 'required|string|max:255',
        'user.identification_number' => 'required|string|regex:/^\d{6}-\d{2}-\d{4}$/|unique:App\Models\Community,identification_number',
        'user.phone_number' => 'required|string|phone:MY',
        'address.category' => 'required|string|exists:address_category,code',
        'address.line_1' => 'required|string|max:255',
        'address.line_2' => 'required|string|max:255',
        'address.line_3' => 'nullable|string|max:255',
        'address.city' => 'required|string|max:255',
        'address.postcode' => 'required|string|max:255',
        'address.state' => 'required|string|in:JOHOR',
        'address.country' => 'required|string|in:MALAYSIA',
        'occupation.place' => 'required_with:occupation.position,occupation.sector|nullable|string|max:255',
        'occupation.position' => 'required_with:occupation.place,occupation.sector|nullable|string|max:255',
        'occupation.sector' => 'required_with:occupation.place,occupation.position|nullable|string|exists:occupation_sector_type,code',
    ];

    public function mount()
    {
        $this->user = new Community;
        $this->address = new Address([
            'state' => 'JOHOR',
            'country' => 'MALAYSIA'
        ]);
        $this->occupation = new Occupation;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function create()
    {
        $this->validate([
            'captcha' => 'recaptcha'
        ]);

        Auth::guard('community')->login($community = Community::create([
            'name' => $this->user->name,
            'identification_number' => $this->user->identification_number,
            'phone_number' => $this->user->phone_number,
            'username' => $this->user->username,
            'email' => $this->user->email,
            'password' => Hash::make($this->user->password),
        ]));

        Occupation::create([
            'community_id' => $community->id,
            'place' => $this->occupation->place,
            'position' => $this->occupation->position,
            'sector' => $this->occupation->sector,
        ]);

        Address::create([
            'community_id' => $community->id,
            'category' => $this->address->category,
            'line_1' => $this->address->line_1,
            'line_2' => $this->address->line_2,
            'line_3' => $this->address->line_3,
            'city' => $this->address->city,
            'postcode' => $this->address->postcode,
            'state' => $this->address->state,
            'country' => $this->address->country,
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
