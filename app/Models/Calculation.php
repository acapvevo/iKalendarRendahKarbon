<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
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
        'total_carbon_emission',
        'average_carbon_emission',
        'total_carbon_reduction',
        'total_carbon_emission_each_type',
        'total_carbon_reduction_each_type',
        'total_usage',
        'average_usage',
        'total_usage_reduction',
        'total_usage_each_type',
        'usage_reduction_each_type',
        'total_charge',
        'average_charge',
        'total_charge_reduction',
        'total_charge_each_type',
        'charge_reduction_each_type',
        'total_weight',
        'average_weight',
        'total_weight_each_type',
        'total_value',
        'average_value',
        'total_value_each_type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'total_carbon_emission_each_type' => AsCollection::class,
        'total_carbon_reduction_each_type' => AsCollection::class,
        'total_usage_each_type' => AsCollection::class,
        'usage_reduction_each_type' => AsCollection::class,
        'total_charge_each_type' => AsCollection::class,
        'charge_reduction_each_type' => AsCollection::class,
        'total_weight_each_type' => AsCollection::class,
        'total_value_each_type' => AsCollection::class,
    ];

    /**
     * Get the parent model (Submission, Bill, Competition or Month).
     */
    public function parent()
    {
        return $this->morphTo();
    }
}
