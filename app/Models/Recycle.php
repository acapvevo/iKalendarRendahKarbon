<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recycle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bill_id',
        'weight',
        'value',
        'carbon_emission',
        'evidence',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Get the Bill that owns the Recycle.
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function calculateCarbonEmission()
    {
        $this->carbon_emission = round($this->weight * 2.860, 2);
    }
}
