<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Occupation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'community_id',
        'place',
        'position',
        'sector',
    ];

    /**
     * Get the Community that owns the Occupation.
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function getSector()
    {
        return DB::table('occupation_sector_type')->where('code', $this->sector)->first();
    }
}
