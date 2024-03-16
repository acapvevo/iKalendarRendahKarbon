<?php

namespace App\Models;

use App\Traits\BillTrait;
use App\Traits\StatTrait;
use App\Traits\ZoneTrait;
use App\Traits\SubmissionTrait;
use App\Traits\CalculationTrait;
use App\Traits\DateTimeTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competition extends Model
{
    use HasFactory, SubmissionTrait, ZoneTrait, CalculationTrait, StatTrait, BillTrait, DateTimeTrait;

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

    public function getMonthRange()
    {
        return $this->months->whereBetween('num', [config('constant.min_month'), config('constant.max_month')])->values();
    }

    public function getMonthNames()
    {
        $monthNames = collect();

        foreach ($this->getMonthRange() as $month) {
            $monthNames->push($month->getShortName());
        }

        return $monthNames;
    }

    public function getTwoMonthNames()
    {
        $monthsArray = collect();
        $months = $this->getMonthRange();

        for ($m = 0; $m < $months->count(); $m++) {
            if ($m == 0)
                continue;

            $currentMonth = $months->get($m);
            $lastMonth = $months->get($m - 1);

            $monthsArray->push($lastMonth->getShortName() . '/' . $currentMonth->getShortName());
        }

        return $monthsArray;
    }

    public function calculateCarbonEmissionStats()
    {
        $total_carbon_emission = $total_weight = $total_value = $total_usage = $total_charge = 0;
        // $total_carbon_reduction = 0;

        $total_carbon_emission_each_type = $total_usage_each_type = $total_charge_each_type = $total_weight_each_type = $total_value_each_type = $this->initCalculationBySubmissionCategory();
        // $total_carbon_reduction_each_type = $usage_reduction_each_type = $charge_reduction_each_type = $this->initCalculationBySubmissionCategory();

        $total_carbon_emission_each_month = $total_carbon_reduction_each_month = $this->initCalculationEachMonth($this);
        $total_carbon_emission_each_zone = $total_carbon_reduction_each_zone = $this->initCalculationEachZone();

        // $total_carbon_emission_each_type_each_month = $total_carbon_reduction_each_type_each_month = $this->initCalculationBySubmissionCategoryEachMonth($this);
        $total_carbon_emission_each_type_each_zone = $total_carbon_reduction_each_type_each_zone = $this->initCalculationBySubmissionCategoryEachZone();

        foreach ($this->submissions as $submission) {
            if (!isset($submission->calculation))
                $submission->calculateStats();

            $calculation = $this->getCalculationByClassAndID($submission->id, Submission::class);

            $total_carbon_emission += $calculation->total_carbon_emission;
            // $total_usage += $calculation->total_usage;
            // $total_charge += $calculation->total_charge;
            // $total_weight += $calculation->total_weight;
            // $total_value += $calculation->total_value;

            if (isset($submission->community->address->zone_id)) {
                $total_carbon_emission_each_zone[$submission->community->address->zone_id] += $calculation->total_carbon_emission;

                foreach ($this->getSubmissionCategories() as $category) {
                    $total_carbon_emission_each_type_each_zone[$submission->community->address->zone_id][$category->name] += round($calculation->total_usage_each_type[$category->name], 2);
                }
            }

            // $total_carbon_reduction += $calculation->total_carbon_reduction;

            foreach ($this->getSubmissionCategories() as $category) {
                foreach (json_decode($category->variables) as $variable) {
                    ${'total_' . $variable . '_each_type'}[$category->name] += $calculation->{'total_' . $variable . '_each_type'}[$category->name];
                }

                // $total_carbon_reduction_each_type[$category->name] += round($calculation->total_carbon_reduction_each_type[$category->name], 2);
                // $usage_reduction_each_type[$category->name] += round($calculation->usage_reduction_each_type[$category->name], 2);
                // $charge_reduction_each_type[$category->name] += round($calculation->charge_reduction_each_type[$category->name], 2);
            }
        }

        // each month calculation
        foreach ($this->getMonthRange() as $month) {
            $total_carbon_emission_each_month[$month->id] += $calculation->total_carbon_emission_each_month[$month->id];
        }

        $calculation = $this->getCalculationByClassAndID($this->id, Competition::class);

        $calculation->total_carbon_emission = $total_carbon_emission;
        // $calculation->total_weight = $total_weight;
        // $calculation->total_value = $total_value;
        // $calculation->total_usage = $total_usage;
        // $calculation->total_charge = $total_charge;

        $calculation->average_carbon_emission_by_month = round($total_carbon_emission / $this->months->count(), 2);
        $calculation->average_carbon_emission_by_zone = round($total_carbon_emission / $this->getZones()->count(), 2);

        $calculation->total_carbon_emission_each_type = $total_carbon_emission_each_type;
        $calculation->total_carbon_emission_each_month = $total_carbon_emission_each_month;
        $calculation->total_carbon_emission_each_zone = $total_carbon_emission_each_zone;

        $calculation->total_carbon_emission_each_type_each_zone = $total_carbon_emission_each_type_each_zone;

        $calculation->total_usage_each_type = $total_usage_each_type;
        $calculation->total_charge_each_type = $total_charge_each_type;
        $calculation->total_weight_each_type = $total_weight_each_type;
        $calculation->total_value_each_type = $total_value_each_type;

        // $calculation->total_carbon_reduction = $total_carbon_reduction;

        // $calculation->total_carbon_reduction_each_type = $total_carbon_reduction_each_type;
        // $calculation->usage_reduction_each_type = $usage_reduction_each_type;
        // $calculation->charge_reduction_each_type = $charge_reduction_each_type;

        $calculation->save();
    }

    public function calculateSubmissionStats()
    {
        $total_submission = $this->submissions->count();
        $total_submission_each_type = $this->initCalculationBySubmissionCategory();
        $total_submission_each_month = $this->initCalculationEachMonth($this);
        $total_submission_each_zone = $this->initCalculationByZone();

        $total_submission_each_type_each_zone = $this->initCalculationBySubmissionCategoryEachZone();

        foreach ($this->getMonthRange() as $month) {
            $total_submission_each_month[$month->id] = $month->bills->count();
        }

        foreach ($this->submissions as $submission) {
            foreach ($this->getSubmissionCategories() as $category) {
                if ($submission->checkSubmissionByCategory($category->name))
                    $total_submission_each_type[$category->name] += 1;
            }

            if ($submission->community->address->zone_id) {
                $total_submission_each_zone[$submission->community->address->zone_id] += 1;

                foreach ($this->getSubmissionCategories() as $category) {
                    if ($submission->checkSubmissionByCategory($category->name))
                        $total_submission_each_type_each_zone[$submission->community->address->zone_id][$category->name] += 1;
                }
            }
        }

        $average_submission_by_month = round($total_submission / $this->months->count(), 2);
        $average_submission_by_zone = round($total_submission / $this->getZones()->count(), 2);

        $stat = $this->getStatByClassAndID($this->id, Competition::class);

        $stat->total_submission = $total_submission;
        $stat->total_submission_each_month = $total_submission_each_month;
        $stat->total_submission_each_zone = $total_submission_each_zone;
        $stat->total_submission_each_type = $total_submission_each_type;

        $stat->total_submission_each_type_each_zone = $total_submission_each_type_each_zone;

        $stat->average_submission_by_month = $average_submission_by_month;
        $stat->average_submission_by_zone = $average_submission_by_zone;

        $stat->save();
    }

    public function getSubmissionsByResident($resident_id)
    {
        return $this->submissions->filter(function ($submission) use ($resident_id) {
            return $submission->community->resident_id === $resident_id;
        });
    }

    public function getRankingByAddressCategory($category_code)
    {
        return $this->getSubmissionsByAddressCategory($category_code)
            ->sortByDesc(function ($submission) {
                $submission->calculateStats();

                return abs($submission->calculation->total_carbon_reduction);
            })
            ->values();
    }

    public function getSubmissionsByAddressCategory($category_code)
    {
        return $this->submissions
            ->filter(function ($submission) use ($category_code) {
                return $submission->community->address->category == $category_code;
            });
    }

    public function getRanking()
    {
        return $this->submissions
            ->reject(function ($submission) {
                return !$submission->community->identification_number;
            })
            ->sortByDesc(function ($submission) {
                $submission->calculateStats();

                return abs($submission->calculation->total_carbon_reduction);
            })
            ->values();
    }

    public function checkCurrentCompetitionDuration()
    {
        $currentDate = $this->getCurrentDate();

        if ($currentDate->month < 4 || $currentDate->month > 11)
            return false;

        return true;
    }
}
