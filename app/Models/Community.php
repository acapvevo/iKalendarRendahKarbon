<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Propaganistas\LaravelPhone\PhoneNumber;

class Community extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['address'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resident_id',
        'name',
        'identification_number',
        'phone_number',
        'image',
        'username',
        'email',
        'password',
        'timezone',
        'isVerified',
        'isSubscribed',
        'identification_card',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the Resident associated with the Community.
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Get the Address associated with the Community.
     */
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    /**
     * Get the Occupation associated with the Community.
     */
    public function occupation()
    {
        return $this->hasOne(Occupation::class);
    }

    public function getPhoneNumber()
    {
        return (string) PhoneNumber::make($this->phone_number)->ofCountry('MY');
    }

    public function viewProfilePicture()
    {
        return Storage::response('profile_picture/community/' . $this->image);
    }

    public function toggleSubscription()
    {
        $this->isSubscribed = !$this->isSubscribed;
        $this->save();
    }

    public function viewIdentificationCard()
    {
        return response()->file(storage_path('app/identification_card/community/' . $this->identification_card_image));
    }

    public function deleteIdentificationCard()
    {
        Storage::delete('identification_card/community/' . $this->identification_card_image);
        $this->identification_card_image = null;
    }

    public function getFolderName()
    {
        return preg_replace('/[^a-zA-Z0-9\-\._]/','', $this->name);
    }

    public function checkCompletion()
    {
        return isset($this->username) && isset($this->email) && isset($this->name) && isset($this->phone_number) && isset($this->identification_number) && ($this->address ? $this->address->checkCompletion() : true);
    }
}
