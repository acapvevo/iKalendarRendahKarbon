<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_id',
        'month_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Get the Submission that owns the Bill.
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    /**
     * Get the Month that owns the Bill.
     */
    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    /**
     * Get the Electric associated with the Bill.
     */
    public function electric()
    {
        return $this->hasOne(Electric::class);
    }

    /**
     * Get the Water associated with the Bill.
     */
    public function water()
    {
        return $this->hasOne(Water::class);
    }

    /**
     * Get the Recycle associated with the Bill.
     */
    public function recycle()
    {
        return $this->hasOne(Recycle::class);
    }

    /**
     * Get the UsedOil associated with the Bill.
     */
    public function usedOil()
    {
        return $this->hasOne(UsedOil::class);
    }
}
