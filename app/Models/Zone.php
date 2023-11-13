<?php

namespace App\Models;

use App\Traits\CalculationTrait;
use App\Traits\CompetitionTrait;
use App\Traits\SubmissionTrait;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory, SubmissionTrait, CalculationTrait, CompetitionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'number',
        'coordinates',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'coordinates' => AsCollection::class
    ];

    /**
     * Get the Addresses associated with the Submission.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function setCoordinates($coordinates)
    {
        $this->coordinates = collect();

        foreach ($coordinates as $coordinate) {
            $latlngArray = explode(',', $coordinate);

            $this->coordinates->push([
                "lat"  => $latlngArray[0],
                "lng" => $latlngArray[1]
            ]);
        }
    }

    public function transformToInput()
    {
        return $this->coordinates->map(function ($coordinate) {
            return $coordinate['lat'] . ',' . $coordinate['lng'];
        });
    }

    public function getCoordinateLeaflet()
    {
        return $this->coordinates->map(function ($coordinate) {
            return [$coordinate['lat'], $coordinate['lng']];
        });
    }

    public function getPolygonArray()
    {
        return $this->coordinates->map(function ($coordinate) {
            return $coordinate['lng'] . ' ' . $coordinate['lat'];
        });
    }

    public function getFormalName()
    {
        return __("Zone") . ' ' . $this->number . ": " . $this->name;
    }

    public function calculateStatsByCompetition($competition_id)
    {
        $competition = $this->getCompetition($competition_id);
        $months = $this->getMonthsByCompetitionID($competition_id);

        $total_carbon_emission_each_month = $total_submission_each_month = $this->initCalculationEachMonthByCompetitionID($competition_id);


        foreach ($months as $month) {
            $bills = $month->bills->filter(function ($bill) {
                return $bill->submission->community->address->zone_id === $this->id;
            });

            $total_submission_each_month[$month->id] = $bills->count();

            foreach ($bills as $bill) {
                $total_carbon_emission_each_month[$month->id] += $bill->calculation->total_carbon_emission;
            }
        }

        $average_carbon_emission_by_month = round($competition->calculation->total_carbon_emission_each_zone[$this->id] / $months->count(), 2);
        $average_submission_by_month = round($competition->stat->total_submission_each_zone[$this->id] / $months->count(), 2);

        return [
            $total_carbon_emission_each_month,
            $total_submission_each_month,
            $average_carbon_emission_by_month,
            $average_submission_by_month
        ];
    }
}
