<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Community extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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

    public function toggleSubscription()
    {
        $this->isSubscribed = !$this->isSubscribed;
        $this->save();
    }

    public function viewIdentificationCard()
    {
        return response()->file(storage_path('app/identification_card/community/' . $this->identification_card));
    }

    public function deleteIdentificationCard()
    {
        Storage::delete('identification_card/community/' . $this->identification_card);
        $this->identification_card = null;
    }
}
