<?php

namespace App\Traits;

use App\Models\Resident;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Auth;

trait ResidentTrait
{
    public function getCurrentResident()
    {
        return Auth::guard('resident')->user();
    }

    public function getResident($id)
    {
        return Resident::find($id);
    }

    public function createResident($resident)
    {
        $resident = Resident::firstOrCreate($resident);

        VerifyEmail::createUrlUsing(function ($notifiable) {
            return URL::temporarySignedRoute(
                'resident.verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        });

        event(new Registered($resident));

        return $resident;
    }
}
