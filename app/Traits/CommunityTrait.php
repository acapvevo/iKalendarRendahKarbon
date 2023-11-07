<?php

namespace App\Traits;

use App\Models\Address;
use App\Models\Community;
use App\Models\Occupation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Imports\BatchCommunityRegistrationImport;

trait CommunityTrait
{
    /**
     * @param array $community
     * @param array $address
     * @param array $occupation
     *
     * @return Community
     */
    public function createCommunity($community, $address, $occupation)
    {
        $community = Community::firstOrCreate($community);

        $address = new Address(array_merge($address, [
            'state' => 'JOHOR',
            'country' => 'MALAYSIA'
        ]));
        $address->setZone();
        $community->address()->save($address);

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

    public function batchCreateCommunity($file)
    {
        Excel::import(new BatchCommunityRegistrationImport, $file);
    }

    public function getCommunity($id)
    {
        return Community::find($id);
    }

    public function getCommunityByEmail($email)
    {
        return Community::firstOrNew([
            'email' => $email
        ]);
    }

    public function searchCommunities($term, $resident_id)
    {
        $communities = Community::with(['address'])
            ->whereNull('resident_id')
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', '%' . $term . '%')
                    ->orWhere('username', 'like', '%' . $term . '%');
            });

        return $communities->paginate(10);
    }

    public function getAddressByCommunityId($community_id)
    {
        if ($community_id)
            return Address::firstOrNew([
                'community_id' => $community_id
            ]);
        else
            return new Address([
                'state' => 'JOHOR',
                'country' => 'MALAYSIA'
            ]);
    }
}
