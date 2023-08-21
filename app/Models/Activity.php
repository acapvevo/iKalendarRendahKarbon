<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year',
    ];

    /**
     * Get all of the Activity's Used Oil.
     */
    public function used_oil()
    {
        return $this->morphOne(UsedOil::class, 'parent');
    }

    /**
     * Get all of the Activity's Recycle.
     */
    public function recycle()
    {
        return $this->morphOne(Recycle::class, 'parent');
    }

    /**
     * Get all of the Activity's Fabric.
     */
    public function fabric()
    {
        return $this->morphOne(Fabric::class, 'parent');
    }

    /**
     * Get all of the Activity's Electronic.
     */
    public function electronic()
    {
        return $this->morphOne(Electronic::class, 'parent');
    }
}
