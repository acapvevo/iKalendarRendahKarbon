<?php

namespace App\Models;

use App\Traits\BillTrait;
use App\Traits\CalculationTrait;
use App\Traits\StatTrait;
use App\Traits\SubmissionTrait;
use App\Traits\ZoneTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competition extends Model
{
    use HasFactory, SubmissionTrait, ZoneTrait, CalculationTrait, StatTrait, BillTrait;

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

    public function getMonthNames()
    {
        $monthNames = collect();

        foreach ($this->months as $month) {
            $monthNames->push($month->getShortName());
        }

        return $monthNames;
    }

    public function calculateCarbonEmissionStats()
    {
        $total_carbon_emission = 0;
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

            $submissionCalculation = $this->getCalculationByClassAndID($submission->id, Submission::class);

            $total_carbon_emission += $submissionCalculation->total_carbon_emission;

            foreach ($this->months as $month) {
                $bill = $this->getBillByMonthAndSubmission($month->id, $submission->id);

                if ($bill->id && !isset($bill->calculation))
                    $bill->calculateStats();

                $billCalculation = $this->getCalculationByClassAndID($bill->id, Bill::class);

                $total_carbon_emission_each_month[$month->id] += $billCalculation->total_carbon_emission;
            }

            if (isset($submission->community->address->zone_id)) {
                $total_carbon_emission_each_zone[$submission->community->address->zone_id] += $submissionCalculation->total_carbon_emission;

                foreach ($this->getSubmissionCategories() as $category) {
                    $total_carbon_emission_each_type_each_zone[$submission->community->address->zone_id][$category->name] += round($submissionCalculation->total_usage_each_type[$category->name], 2);
                }
            }

            // $total_carbon_reduction += $submissionCalculation->total_carbon_reduction;

            foreach ($this->getSubmissionCategories() as $category) {
                $total_carbon_emission_each_type[$category->name] += $submissionCalculation->total_carbon_emission_each_type[$category->name];
                // $total_usage_each_type[$category->name] += round($submissionCalculation->total_usage_each_type[$category->name], 2);
                // $total_charge_each_type[$category->name] += round($submissionCalculation->total_charge_each_type[$category->name], 2);
                // $total_weight_each_type[$category->name] += round($submissionCalculation->total_weight_each_type[$category->name], 2);
                // $total_value_each_type[$category->name] += round($submissionCalculation->total_value_each_type[$category->name], 2);

                // $total_carbon_reduction_each_type[$category->name] += round($submissionCalculation->total_carbon_reduction_each_type[$category->name], 2);
                // $usage_reduction_each_type[$category->name] += round($submissionCalculation->usage_reduction_each_type[$category->name], 2);
                // $charge_reduction_each_type[$category->name] += round($submissionCalculation->charge_reduction_each_type[$category->name], 2);
            }
        }


        $calculation = $this->getCalculationByClassAndID($this->id, Competition::class);

        $calculation->total_carbon_emission = $total_carbon_emission;
        $calculation->average_carbon_emission_by_month = round($total_carbon_emission / $this->months->count(), 2);
        $calculation->average_carbon_emission_by_zone = round($total_carbon_emission / $this->getZones()->count(), 2);

        $calculation->total_carbon_emission_each_type = $total_carbon_emission_each_type;
        $calculation->total_carbon_emission_each_month = $total_carbon_emission_each_month;
        $calculation->total_carbon_emission_each_zone = $total_carbon_emission_each_zone;

        $calculation->total_carbon_emission_each_type_each_zone = $total_carbon_emission_each_type_each_zone;

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
        $total_submission = $this->submissions->count();
        $total_submission_each_type = $this->initCalculationBySubmissionCategory();
        $total_submission_each_month = $this->initCalculationEachMonth($this);
        $total_submission_each_zone = $this->initCalculationByZone();

        $total_submission_each_type_each_zone = $this->initCalculationBySubmissionCategoryEachZone();

        foreach ($this->months as $month) {
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
}
