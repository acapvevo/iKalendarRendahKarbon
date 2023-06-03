<?php

namespace App\Http\Controllers\Community\Auth;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

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
            'profile.identification_number' => 'required|string|regex:/^\d{6}-\d{2}-\d{4}$/',
            'profile.phone_number' => 'required|string|unique:App\Models\Community,phone_number',
            'address.address_line_1' => 'required|string|max:255',
            'address.address_line_2' => 'required|string|max:255',
            'address.address_line_3' => 'sometimes|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.postcode' => 'required|string|max:255',
            'address.state' => 'required|string|in:JOHOR',
            'address.country' => 'required|string|in:MALAYSIA',
        ]);

        Auth::guard('community')->login($community = Community::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]));

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
