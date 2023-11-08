<?php

namespace App\Models;

use App\Traits\SubmissionTrait;
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
        'total_carbon_emission_each_month',
        'total_carbon_emission_each_zone',
        'total_carbon_emission_each_type',
        'total_carbon_emission_each_type_each_month',
        'total_carbon_emission_each_type_each_zone',
        'average_carbon_emission_by_month',
        'average_carbon_emission_by_zone',

        'total_carbon_reduction',
        'total_carbon_reduction_each_month',
        'total_carbon_reduction_each_zone',
        'total_carbon_reduction_each_type',
        'total_carbon_reduction_each_type_each_month',
        'total_carbon_reduction_each_type_each_zone',
        'average_carbon_reduction_by_month',
        'average_carbon_reduction_by_zone',

        'total_usage_each_type',
        'total_usage_each_type_each_month',
        'total_usage_each_type_each_zone',
        'average_usage_each_type_by_month',
        'average_usage_each_type_by_zone',

        'usage_reduction_each_type',
        'usage_reduction_each_type_each_month',
        'usage_reduction_each_type_each_zone',
        'average_usage_reduction_each_type_by_month',
        'average_usage_reduction_each_type_by_zone',

        'total_charge_each_type',
        'total_charge_each_type_each_month',
        'total_charge_each_type_each_zone',
        'average_charge_each_type_by_month',
        'average_charge_each_type_by_zone',

        'charge_reduction_each_type',
        'charge_reduction_each_type_each_month',
        'charge_reduction_each_type_each_zone',
        'average_charge_reduction_each_type_by_month',
        'average_charge_reduction_each_type_by_zone',

        'total_weight_each_type',
        'total_weight_each_type_each_month',
        'total_weight_each_type_each_zone',
        'average_total_weight_each_type_by_month',
        'average_total_weight_each_type_by_zone',

        'total_value_each_type',
        'total_value_each_type_each_month',
        'total_value_each_type_each_zone',
        'average_total_value_each_type_by_month',
        'average_total_value_each_type_by_zone',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'total_carbon_emission_each_month' => AsCollection::class,
        'total_carbon_emission_each_zone' => AsCollection::class,
        'total_carbon_emission_each_type' => AsCollection::class,
        'total_carbon_emission_each_type_each_month' => AsCollection::class,
        'total_carbon_emission_each_type_each_zone' => AsCollection::class,

        'total_carbon_reduction_each_month' => AsCollection::class,
        'total_carbon_reduction_each_zone' => AsCollection::class,
        'total_carbon_reduction_each_type' => AsCollection::class,
        'total_carbon_reduction_each_type_each_month' => AsCollection::class,
        'total_carbon_reduction_each_type_each_zone' => AsCollection::class,

        'total_usage_each_type' => AsCollection::class,
        'total_usage_each_type_each_month' => AsCollection::class,
        'total_usage_each_type_each_zone' => AsCollection::class,
        'average_usage_each_type_by_month' => AsCollection::class,
        'average_usage_each_type_by_zone' => AsCollection::class,

        'usage_reduction_each_type' => AsCollection::class,
        'usage_reduction_each_type_each_month' => AsCollection::class,
        'usage_reduction_each_type_each_zone' => AsCollection::class,
        'average_usage_reduction_each_type_by_month' => AsCollection::class,
        'average_usage_reduction_each_type_by_zone' => AsCollection::class,

        'total_charge_each_type' => AsCollection::class,
        'total_charge_each_type_each_month' => AsCollection::class,
        'total_charge_each_type_each_zone' => AsCollection::class,
        'average_charge_each_type_by_month' => AsCollection::class,
        'average_charge_each_type_by_zone' => AsCollection::class,

        'charge_reduction_each_type' => AsCollection::class,
        'charge_reduction_each_type_each_month' => AsCollection::class,
        'charge_reduction_each_type_each_zone' => AsCollection::class,
        'average_charge_reduction_each_type_by_month' => AsCollection::class,
        'average_charge_reduction_each_type_by_zone' => AsCollection::class,

        'total_weight_each_type' => AsCollection::class,
        'total_weight_each_type_each_month' => AsCollection::class,
        'total_weight_each_type_each_zone' => AsCollection::class,
        'average_total_weight_each_type_by_month' => AsCollection::class,
        'average_total_weight_each_type_by_zone' => AsCollection::class,

        'total_value_each_type' => AsCollection::class,
        'total_value_each_type_each_month' => AsCollection::class,
        'total_value_each_type_each_zone' => AsCollection::class,
        'average_total_value_each_type_by_month' => AsCollection::class,
        'average_total_value_each_type_by_zone' => AsCollection::class,
    ];

    /**
     * Get the parent model (Submission, Bill, Competition or Month).
     */
    public function parent()
    {
        return $this->morphTo();
    }

    public function getTotalStats($variable)
    {
        $total = 0;

        foreach ($this->{'total_' . $variable . '_each_type'} as $item)
            $total += $item;

        return $total;
    }

    public function getReductionStats($variable)
    {
        $total = 0;

        foreach ($this->{$variable . '_reduction_each_type'} as $item)
            $total += $item;

        return $total;
    }
}
