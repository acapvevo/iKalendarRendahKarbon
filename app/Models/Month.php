<?php

namespace App\Models;

use App\Traits\CalculationTrait;
use App\Traits\StatTrait;
use App\Traits\SubmissionTrait;
use App\Traits\ZoneTrait;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Month extends Model
{
    use HasFactory, ZoneTrait, SubmissionTrait, CalculationTrait, StatTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'num',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the Competition that owns the Month.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * Get the Bills associated with the Month.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * Get the Calculation associated with the Competition.
     */
    public function calculation()
    {
        return $this->morphOne(Calculation::class, 'parent');
    }

    /**
     * Get the Stat associated with the Competition.
     */
    public function stat()
    {
        return $this->morphOne(Stat::class, 'parent');
    }

    public function getName()
    {
        return Carbon::create(0, $this->num)->locale(LaravelLocalization::getCurrentLocale())->translatedFormat('F');
    }

    public function getShortName()
    {
        return Carbon::create(0, $this->num)->locale(LaravelLocalization::getCurrentLocale())->translatedFormat('M');
    }

    public function getUploadName()
    {
        return Carbon::create(0, $this->num)->format('F');
    }

    public function getTotalCarbonEmission()
    {
        $total_carbon_emission = 0;

        foreach ($this->bills as $bill) {
            $total_carbon_emission += $bill->total_carbon_emission;
        }

        return number_format($total_carbon_emission, 2);
    }

    public function getBillsByZone($zone_id)
    {
        return $this->bills->filter(function ($bill) use ($zone_id) {
            return $bill->submission->community->zone_id = $zone_id;
        });
    }

    public function calculateCarbonEmissionStats()
    {
        $total_carbon_emission = 0;
        // $total_carbon_reduction = 0;

        $total_carbon_emission_each_type = $total_usage_each_type = $total_charge_each_type = $total_weight_each_type = $total_value_each_type = $this->initCalculationBySubmissionCategory();
        // $total_carbon_reduction_each_type = $usage_reduction_each_type = $charge_reduction_each_type = $this->initCalculationBySubmissionCategory();

        $total_carbon_emission_each_zone = $total_carbon_reduction_each_zone = $this->initCalculationEachZone();

        // $total_carbon_emission_each_type_each_month = $total_carbon_reduction_each_type_each_month = $this->initCalculationBySubmissionCategoryEachMonth($this);
        // $total_carbon_emission_each_type_each_zone = $total_carbon_reduction_each_type_each_zone = $this->initCalculationBySubmissionCategoryEachZone();

        foreach ($this->bills as $bill) {
            if (!isset($bill->calculation))
                $bill->calculateStats();

            $billCalculation = $this->getCalculationByClassAndID($bill->id, Bill::class);

            $total_carbon_emission += $billCalculation->total_carbon_emission;

            if (isset($bill->submission->community->address->zone_id))
                $total_carbon_emission_each_zone[$bill->submission->community->address->zone_id] += $billCalculation->total_carbon_emission;

            // $total_carbon_reduction += $submissionCalculation->total_carbon_reduction;

            foreach ($this->getSubmissionCategories() as $category) {
                $total_carbon_emission_each_type[$category->name] += round($bill->{$category->name}->carbon_emission ?? 0, 2);
                // $total_usage_each_type[$category->name] += round($bill->{$category->name}->usage ?? 0, 2);
                // $total_charge_each_type[$category->name] += round($bill->{$category->name}->charge ?? 0, 2);
                // $total_weight_each_type[$category->name] += round($bill->{$category->name}->weight ?? 0, 2);
                // $total_value_each_type[$category->name] += round($bill->{$category->name}->value ?? 0, 2);

                // $total_carbon_reduction_each_type[$category->name] += round($submissionCalculation->total_carbon_reduction_each_type[$category->name], 2);
                // $usage_reduction_each_type[$category->name] += round($submissionCalculation->usage_reduction_each_type[$category->name], 2);
                // $charge_reduction_each_type[$category->name] += round($submissionCalculation->charge_reduction_each_type[$category->name], 2);
            }
        }


        $calculation = $this->getCalculationByClassAndID($this->id, __CLASS__);

        $calculation->total_carbon_emission = $total_carbon_emission;
        $calculation->average_carbon_emission_by_zone = round($total_carbon_emission / $this->getZones()->count(), 2);

        $calculation->total_carbon_emission_each_type = $total_carbon_emission_each_type;
        $calculation->total_carbon_emission_each_zone = $total_carbon_emission_each_zone;

        // $calculation->total_usage_each_type = $total_usage_each_type;
        // $calculation->total_charge_each_type = $total_charge_each_type;
        // $calculation->total_weight_each_type = $total_weight_each_type;
        // $calculation->total_value_each_type = $total_value_each_type;

        // $calculation->total_carbon_reduction = $total_carbon_reduction;

        // $calculation->total_carbon_reduction_each_type = $total_carbon_reduction_each_type;
        // $calculation->usage_reduction_each_type = $usage_reduction_each_type;
        // $calculation->charge_reduction_each_type = $charge_reduction_each_type;

        $calculation->save();
    }

    public function calculateSubmissionStats()
    {
        $total_submission = $this->bills->count();
        $total_submission_each_type = $this->initCalculationBySubmissionCategory();
        $total_submission_each_zone = $this->initCalculationByZone();

        foreach ($this->bills as $bill) {
            foreach ($this->getSubmissionCategories() as $category) {
                if ($bill->{$category->name})
                    $total_submission_each_type[$category->name] += 1;
            }

            if ($bill->submission->community->address->zone_id)
                $total_submission_each_zone[$bill->submission->community->address->zone_id] += 1;
        }

        $average_submission_by_zone = round($total_submission / $this->getZones()->count(), 2);

        $stat = $this->getStatByClassAndID($this->id, __CLASS__);

        $stat->total_submission = $total_submission;
        $stat->total_submission_each_zone = $total_submission_each_zone;
        $stat->total_submission_each_type = $total_submission_each_type;
        $stat->average_submission_by_zone = $average_submission_by_zone;

        $stat->save();
    }
}
