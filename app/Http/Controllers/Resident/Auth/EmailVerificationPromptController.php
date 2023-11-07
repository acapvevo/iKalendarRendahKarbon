<?php

namespace App\Http\Controllers\Resident\Auth;

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
        return $request->user('resident')->hasVerifiedEmail()
                    ? redirect()->intended(route('resident.dashboard'))
                    : view('resident.auth.verify-email');
    }
}
