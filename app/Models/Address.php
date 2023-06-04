<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'community_id',
        'line_1',
        'line_2',
        'line_3',
        'city',
        'postcode',
        'state',
        'country',
    ];


    /**
     * Get the Community that owns the Address.
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
