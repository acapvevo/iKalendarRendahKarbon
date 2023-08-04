<?php

namespace App\Traits;

use App\Models\Address;
use App\Models\Community;
use App\Models\Occupation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Notifications\VerifyEmail;

trait CommunityTrait
{
    public function createCommunity($community, $address, $occupation)
    {
        $community = Community::create($community);

        $community->address()->save(new Address($address));
        $community->occupation()->save(new Occupation($occupation));

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

        return $community;
    }

    public function getCommunity($id)
    {
        return Community::find($id);
    }
}
