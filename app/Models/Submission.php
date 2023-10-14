<?php

namespace App\Models;

use App\Traits\BillTrait;
use App\Traits\CalculationTrait;
use App\Traits\SubmissionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory, SubmissionTrait, BillTrait, CalculationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'community_id',
        'competition_id',
        'total_carbon_emission',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the Community that owns the Submission.
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    /**
     * Get the Competition that owns the Submission.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * Get the Evidences associated with the Submission.
     */
    public function evidences()
    {
        return $this->hasMany(Evidence::class);
    }

    /**
     * Get the Bills associated with the Submission.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * Get the Answers associated with the Submission.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the Calculation associated with the Submission.
     */
    public function calculation()
    {
        return $this->morphOne(Calculation::class, 'parent');
    }

    public function checkBillsSubmit()
    {
        if ($this->bills->isEmpty())
            return __('Not Submitted');
        else if ($this->bills->count() == 12)
            return __('Fully Submitted');
        else
            return __('Partially Submitted');
    }

    public function calculateStats()
    {
        $total_carbon_emission = $total_charge = $total_usage = $total_weight = $total_value = 0;
        $total_carbon_reduction = $total_usage_reduction = $total_charge_reduction = 0;

        $total_carbon_emission_each_type = $total_usage_each_type = $total_charge_each_type = $total_weight_each_type = $total_value_each_type = $this->initCalculationBySubmissionCategory();
        $total_carbon_reduction_each_type = $usage_reduction_each_type = $charge_reduction_each_type = $this->initCalculationBySubmissionCategory();

        for ($i = 0; $i < $this->competition->months->count(); $i++) {
            $month = $this->competition->months->get($i);

            if ($this->bills->contains('month_id', $month->id)) {
                $bill = $this->getBillByMonth($month->id);

                if (!isset($bill->calculation)) {
                    $bill->calculateStats();
                }

                $total_carbon_emission += $bill->calculation->total_carbon_emission;
                $total_charge += $bill->calculation->total_charge;
                $total_usage += $bill->calculation->total_usage;
                $total_weight += $bill->calculation->total_weight;
                $total_value += $bill->calculation->total_value;

                foreach ($this->getSubmissionCategories() as $category) {
                    $total_carbon_emission_each_type[$category->name] += round($bill->{$category->name}->carbon_emission ?? 0, 2);
                    $total_usage_each_type[$category->name] += round($bill->{$category->name}->usage ?? 0, 2);
                    $total_charge_each_type[$category->name] += round($bill->{$category->name}->charge ?? 0, 2);
                    $total_weight_each_type[$category->name] += round($bill->{$category->name}->weight ?? 0, 2);
                    $total_value_each_type[$category->name] += round($bill->{$category->name}->value ?? 0, 2);
                }

                if ($i !== 0) {
                    $lastMonth = $this->competition->months->get($i - 1);

                    if ($this->bills->contains('month_id', $lastMonth->id)) {
                        $lastBill = $this->getBillByMonth($lastMonth->id);

                        $carbon_reduction = $bill->calculation->total_carbon_emission - $lastBill->calculation->total_carbon_emission;
                        if ($carbon_reduction < 0)
                            $total_carbon_reduction += $carbon_reduction;

                        $usage_reduction = $bill->calculation->total_usage - $lastBill->calculation->total_usage;
                        if ($usage_reduction < 0)
                            $total_usage_reduction += $usage_reduction;

                        $charge_reduction = $bill->calculation->total_charge - $lastBill->calculation->total_charge;
                        if ($charge_reduction < 0)
                            $total_charge_reduction += $charge_reduction;

                        foreach ($this->getSubmissionCategories() as $category) {
                            if (isset($bill->{$category->name}) && isset($lastBill->{$category->name})) {
                                $carbon_reduction = ($bill->{$category->name}->carbon_emission ?? 0) - ($lastBill->{$category->name}->carbon_emission ?? 0);
                                if ($carbon_reduction < 0)
                                    $total_carbon_reduction_each_type[$category->name] += $carbon_reduction;

                                $charge_reduction = ($bill->{$category->name}->charge ?? 0) - ($lastBill->{$category->name}->charge ?? 0);
                                if ($charge_reduction < 0)
                                    $charge_reduction_each_type[$category->name] += $charge_reduction;

                                $usage_reduction = ($bill->{$category->name}->usage ?? 0) - ($lastBill->{$category->name}->usage ?? 0);
                                if ($usage_reduction < 0)
                                    $usage_reduction_each_type[$category->name] += $usage_reduction;
                            }
                        }
                    }
                }
            }
        }

        $calculation = $this->getCalculationByClassAndID($this->id, Submission::class);

        $calculation->total_carbon_emission = $total_carbon_emission;
        $calculation->total_charge = $total_charge;
        $calculation->total_usage = $total_usage;
        $calculation->total_weight = $total_weight;
        $calculation->total_value = $total_value;

        $calculation->total_carbon_emission_each_type = $total_carbon_emission_each_type;
        $calculation->total_usage_each_type = $total_usage_each_type;
        $calculation->total_charge_each_type = $total_charge_each_type;
        $calculation->total_weight_each_type = $total_weight_each_type;
        $calculation->total_value_each_type = $total_value_each_type;

        $calculation->total_carbon_reduction = $total_carbon_reduction;
        $calculation->total_usage_reduction = $total_usage_reduction;
        $calculation->total_charge_reduction = $total_charge_reduction;

        $calculation->total_carbon_reduction_each_type = $total_carbon_reduction_each_type;
        $calculation->usage_reduction_each_type = $usage_reduction_each_type;
        $calculation->charge_reduction_each_type = $charge_reduction_each_type;

        $calculation->save();
    }

    public function calculateTotalCarbonEmission()
    {
        $this->calculateStats();
    }

    public function getTotalCarbonEmissionByMonthID($month_id)
    {
        $bill = $this->getBillByMonthID($month_id);

        return $bill->total_carbon_emission ?? 0;
    }

    public function getBillByMonthID($month_id)
    {
        return $this->bills->where('month_id', $month_id)->first() ?? new Bill([
            'month_id' => $month_id,
            'submission_id' => $this->id,
        ]);
    }

    public function getAnswerByQuestionID($question_id)
    {
        return $this->answers->where('question_id', $question_id)->first() ?? new Answer([
            'question_id' => $question_id,
            'submission_id' => $this->id,
        ]);
    }

    public function getTotalCarbonEmission()
    {
        return number_format($this->total_carbon_emission, 2) . ' kgCO<sub>2</sub>';
    }

    public function checkSubmissionByCategory($category)
    {
        return $this->bills->contains(function ($bill) use ($category) {
            return isset($bill->{$category});
        });
    }

    public function getCarbonEmissionStats()
    {
        $total_carbon_emission_by_category = $this->initCalculationBySubmissionCategory();

        foreach ($this->bills as $bill) {
            foreach ($total_carbon_emission_by_category as $category => $value) {
                if ($bill->{$category})
                    $total_carbon_emission_by_category[$category] += $bill->{$category}->carbon_emission;
            }
        }

        return [
            $total_carbon_emission_by_category
        ];
    }

    public function getEvidensByCategory($category)
    {
        return $this->evidences->filter(function ($evidence) use ($category) {
            return $evidence->category == $category;
        });
    }
}
