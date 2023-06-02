<?php

namespace App\Http\Controllers\Community\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user('community')->hasVerifiedEmail()
                    ? redirect()->intended(route('community.dashboard'))
                    : view('community.auth.verify-email');
    }
}
