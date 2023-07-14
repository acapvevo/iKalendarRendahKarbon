<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'category',
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

    public function getCategory()
    {
        return DB::table('address_category')->where('code', $this->category)->first();
    }
}
