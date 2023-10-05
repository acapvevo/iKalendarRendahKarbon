<?php

namespace App\Models;

use App\Traits\SubmissionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory, SubmissionTrait;

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
        $total_carbon_emission = 0;

        foreach ($this->bills as $bill) {
            $bill->calculateTotalCarbonEmission();
            $total_carbon_emission += $bill->calculation->total_carbon_emission;
        }
    }

    public function calculateTotalCarbonEmission()
    {
        $this->calculateStats();

        $this->save();
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
}
