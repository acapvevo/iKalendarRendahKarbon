<?php

namespace App\Http\Controllers\Community\Auth;

use App\Models\Address;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Notifications\VerifyEmail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('community.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'account.username' => 'required|string|max:255|unique:communities,username',
            'account.email' => 'required|string|email|max:255|unique:communities,email',
            'account.password' => 'required|string|confirmed|min:8',
            'profile.name' => 'required|string|max:255',
            'profile.identification_number' => 'required|string|regex:/^\d{6}-\d{2}-\d{4}$/|unique:App\Models\Community,identification_number',
            'profile.phone_number' => 'required|string',
            'address.line_1' => 'required|string|max:255',
            'address.line_2' => 'required|string|max:255',
            'address.line_3' => 'sometimes|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.postcode' => 'required|string|max:255',
            'address.state' => 'required|string|in:JOHOR',
            'address.country' => 'required|string|in:MALAYSIA',
            'g-recaptcha-response' => 'recaptcha'
        ]);

        Auth::guard('community')->login($community = Community::create([
            'name' => $request->profile['name'],
            'identification_number' => $request->profile['identification_number'],
            'phone_number' => $request->profile['phone_number'],
            'username' => $request->account['username'],
            'email' => $request->account['email'],
            'password' => Hash::make($request->account['password']),
        ]));

        Address::create([
            'community_id' => $community->id,
            'line_1' => $request->address['line_1'],
            'line_2' => $request->address['line_2'],
            'line_3' => $request->address['line_3'],
            'city' => $request->address['city'],
            'postcode' => $request->address['postcode'],
            'state' => $request->address['state'],
            'country' => $request->address['country'],
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
}
