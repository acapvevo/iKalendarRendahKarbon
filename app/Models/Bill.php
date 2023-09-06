<?php

namespace App\Models;

use App\Traits\SubmissionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory, SubmissionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_id',
        'month_id',
        'total_carbon_emission',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

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
     * Get all of the Bill's Electric.
     */
    public function electric()
    {
        return $this->morphOne(Electric::class, 'parent');
    }

    /**
     * Get all of the Bill's Water.
     */
    public function water()
    {
        return $this->morphOne(Water::class, 'parent');
    }

    /**
     * Get all of the Bill's Used Oil.
     */
    public function used_oil()
    {
        return $this->morphOne(UsedOil::class, 'parent');
    }

    /**
     * Get all of the Bill's Recycle.
     */
    public function recycle()
    {
        return $this->morphOne(Recycle::class, 'parent');
    }

    public function isDoneSubmit()
    {
        return $this->electric->carbon_emission && $this->water->carbon_emission && $this->recycle->carbon_emission && $this->used_oil->carbon_emission;
    }

    public function calculateTotalCarbonEmission()
    {
        $this->total_carbon_emission = ($this->electric->carbon_emission ?? 0) + ($this->water->carbon_emission ?? 0) + ($this->recycle->carbon_emission ?? 0) + ($this->used_oil->carbon_emission ?? 0);
        $this->save();
    }

    public function getCarbonEmissionStats()
    {
        $total_carbon_emission_by_category = $this->initCalculationBySubmissionCategory();

        foreach($total_carbon_emission_by_category as $category => $value){
            if($this->{$category})
            $total_carbon_emission_by_category[$category] += $this->{$category}->carbon_emission;
        }

        return [
            $total_carbon_emission_by_category
        ];
    }
}
