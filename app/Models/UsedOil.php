<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedOil extends Model
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
     * Get the Bill that owns the UsedOil.
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function calculateCarbonEmission()
    {
        $this->carbon_emission = round($this->weight * 3.200, 2);
    }
}