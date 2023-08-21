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
        'parent_id',
        'parent_type',
        'weight',
        'value',
        'carbon_emission',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Get the parent model (Bill or Activity).
     */
    public function parent()
    {
        return $this->morphTo();
    }

    public function calculateCarbonEmission()
    {
        $this->carbon_emission = round($this->weight * 3.200, 2);
    }
}
