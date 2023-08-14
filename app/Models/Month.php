<?php

namespace App\Models;

use App\Traits\SubmissionTrait;
use App\Traits\ZoneTrait;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Month extends Model
{
    use HasFactory, ZoneTrait, SubmissionTrait;

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
     * Get the Competiton that owns the Month.
     */
    public function competiton()
    {
        return $this->belongsTo(Competiton::class);
    }

    /**
     * Get the Bills associated with the Month.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
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

    public function getCarbonEmissionStats()
    {
        $total_carbon_emission = $this->getTotalCarbonEmission();
        $total_carbon_emission_by_zone = $this->initCalculationByZone();
        $total_carbon_emission_by_category = $this->initCalculationBySubmissionCategory();

        // foreach ($this->getZones() as $zone) {
        //     foreach ($this->getBillsByZone($zone->id) as $bill) {
        //         $total_carbon_emission_by_zone[$zone->id] += $bill->total_carbon_emission;
        //     }

        //     $average_carbon_emission_by_zone[$zone->id] = $total_carbon_emission_by_zone[$zone->id]/$this->competiton->months->count();
        // }

        $average_carbon_emission_by_zone = $total_carbon_emission / $this->getZones()->count();

        foreach ($this->bills as $bill) {
            foreach ($total_carbon_emission_by_category as $category => $value) {
                if ($bill->{$category})
                    $total_carbon_emission_by_category[$category] += $bill->{$category}->carbon_emission;
            }
        }

        return [
            $total_carbon_emission_by_zone,
            $total_carbon_emission,
            $average_carbon_emission_by_zone,
            $total_carbon_emission_by_category
        ];
    }

    public function getSubmissionStats()
    {
        $total_submission = $this->bills->count();
        $total_submission_by_zone = $this->initCalculationByZone();
        $total_submission_by_category = $this->initCalculationBySubmissionCategory();

        // foreach ($this->getZones() as $zone) {
        //     foreach ($this->getBillsByZone($zone->id) as $bill) {
        //         $total_carbon_emission_by_zone[$zone->id] += $bill->total_carbon_emission;
        //     }

        //     $average_carbon_emission_by_zone[$zone->id] = $total_carbon_emission_by_zone[$zone->id]/$this->competiton->months->count();
        // }

        $average_submission_by_zone = $total_submission / $this->getZones()->count();

        foreach ($this->bills as $bill) {
            foreach ($total_submission_by_category as $category => $value) {
                if ($bill->{$category})
                    $total_submission_by_category[$category] += 1;
            }
        }

        return [
            $total_submission_by_zone,
            $total_submission,
            $average_submission_by_zone,
            $total_submission_by_category
        ];
    }
}
