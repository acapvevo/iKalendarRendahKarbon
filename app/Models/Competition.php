<?php

namespace App\Models;

use App\Traits\SubmissionTrait;
use App\Traits\ZoneTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competition extends Model
{
    use HasFactory, SubmissionTrait, ZoneTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'year',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the Months associated with the Competition.
     */
    public function months()
    {
        return $this->hasMany(Month::class);
    }

    /**
     * Get the Questions associated with the Competition.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the Submissions associated with the Competition.
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function generateMonth()
    {
        for ($i = 1; $i <= 12; $i++) {
            Month::create([
                'competition_id' => $this->id,
                'num' => $i,
            ]);
        }
    }

    public function checkSubmissionStatus()
    {
        $community_id = Auth::user()->id;
        $submission = $this->getSubmissionByCommunityID($community_id);

        if ($submission) {
            return $submission->checkBillsSubmit();
        } else {
            return __('Not Submitted');
        }
    }

    public function getSubmissionByCommunityID($community_id)
    {
        return $this->submissions->where('community_id', $community_id)->first();
    }

    public function getQuestionCategories()
    {
        return $this->questions->pluck('category')->unique()->values();
    }

    public function getQuestionsByCategory($questionCategory)
    {
        return $this->questions->where('category', $questionCategory)->values();
    }

    public function getMonthNames()
    {
        $monthNames = collect();

        foreach ($this->months as $month) {
            $monthNames->push($month->getShortName());
        }

        return $monthNames;
    }

    public function getCarbonEmissionStats()
    {
        $total_carbon_emission_by_month = collect();
        $total_carbon_emission_every_category = $average_carbon_emission_every_category_by_month = $average_carbon_emission_every_category_by_zone = $this->initCalculationBySubmissionCategory();
        $total_carbon_emission = 0;

        foreach ($this->months as $month) {
            $currentTotalMonth = $month->getTotalCarbonEmission();

            $total_carbon_emission_by_month->push($currentTotalMonth);
            $total_carbon_emission += $currentTotalMonth;

            foreach ($total_carbon_emission_every_category as $category => $value) {
                foreach ($month->bills as $bill) {
                    if ($bill->{$category}) {
                        $total_carbon_emission_every_category[$category] += $bill->{$category}->carbon_emission;
                    }
                }

                $average_carbon_emission_every_category_by_month[$category] = $total_carbon_emission_every_category[$category] / $this->months->count();
            }
        }

        $average_carbon_emission_by_month = $total_carbon_emission / $this->months->count();
        $average_carbon_emission_by_zone = $total_carbon_emission / $this->getZones()->count();

        $total_carbon_emission_by_zone = $this->initCalculationByZone();

        foreach ($this->getZones() as $zone) {
            $bills = $zone->getSubmissions()->filter(function ($submission) {
                return $submission->competition_id = $this->id;
            });

            foreach ($bills as $bill) {
                $total_carbon_emission_by_zone[$zone->id] += $bill->total_carbon_emission;
                foreach ($total_carbon_emission_every_category as $category => $value) {
                    // if ($bill->{$category}) {
                    //     $total_carbon_emission_by_zone[$zone->id] += $bill->{$category}->carbon_emission;
                    // }

                    // $average_carbon_emission_every_category_by_zone[$category] = $total_carbon_emission_by_zone[$zone->id] / $this->getZones()->count();
                }
            }
        }

        return [
            $total_carbon_emission_by_month,
            $total_carbon_emission_by_zone,
            $average_carbon_emission_by_month,
            $average_carbon_emission_by_zone,
            $total_carbon_emission_every_category,
            $total_carbon_emission,
            $average_carbon_emission_every_category_by_month,
            $average_carbon_emission_every_category_by_zone,
        ];
    }

    public function getSubmissionStats()
    {
        $total_submission = $this->submissions->count();
        $total_submission_every_category = $average_submission_every_category_by_month = $average_submission_every_category_by_zone = $this->initCalculationBySubmissionCategory();
        $total_submission_by_month = collect();
        $total_submission_by_zone = $this->initCalculationByZone();

        foreach ($this->months as $month) {
            $currentTotalMonth = $month->bills->count();

            $total_submission_by_month->push($currentTotalMonth);
        }

        foreach ($total_submission_every_category as $category => $value) {
            foreach ($this->submissions as $submission) {
                if ($submission->checkSubmissionByCategory($category))
                    $total_submission_every_category[$category] += 1;
            }

            $average_submission_every_category_by_month[$category] = $total_submission_every_category[$category] / $this->months->count();
        }

        $average_submission_by_month = $total_submission / $this->months->count();
        $average_submission_by_zone = $total_submission / $this->getZones()->count();

        $total_submission_by_zone = $this->initCalculationByZone();

        foreach ($this->getZones() as $zone) {
            $bills = $zone->getSubmissions()->filter(function ($submission) {
                return $submission->competition_id = $this->id;
            });

            foreach ($bills as $bill) {
                $total_submission_by_zone[$zone->id] += 1;
                foreach ($total_submission_every_category as $category => $value) {
                    // if ($bill->{$category}) {
                    //     $total_submission_by_zone[$zone->id] += $bill->{$category}->submission;
                    // }

                    // $average_submission_every_category_by_zone[$category] = $total_submission_by_zone[$zone->id] / $this->getZones()->count();
                }
            }
        }

        return [
            $total_submission_by_month,
            $total_submission_by_zone,
            $average_submission_by_month,
            $average_submission_by_zone,
            $total_submission_every_category,
            $total_submission,
            $average_submission_every_category_by_month,
            $average_submission_every_category_by_zone,
        ];
    }
}
