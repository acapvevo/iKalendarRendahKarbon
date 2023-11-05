<?php

namespace App\Http\Controllers\Resident\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated resident's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user('resident')->hasVerifiedEmail()) {
            return redirect()->intended(route('resident.dashboard').'?verified=1');
        }

        if ($request->user('resident')->markEmailAsVerified()) {
            event(new Verified($request->user('resident')));
        }

        return redirect()->intended(route('resident.dashboard').'?verified=1');
    }
}
