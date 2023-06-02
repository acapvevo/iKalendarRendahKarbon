<?php

namespace App\Http\Controllers\Community\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated community's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user('community')->hasVerifiedEmail()) {
            return redirect()->intended(route('community.dashboard').'?verified=1');
        }

        if ($request->user('community')->markEmailAsVerified()) {
            event(new Verified($request->user('community')));
        }

        return redirect()->intended(route('community.dashboard').'?verified=1');
    }
}
