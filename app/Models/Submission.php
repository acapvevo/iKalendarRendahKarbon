<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

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

    public function checkBillsSubmit()
    {
        if ($this->bills->isEmpty())
            return __('Not Submitted');
        else if ($this->bills->count() == 12)
            return __('Fully Submitted');
        else
            return __('Partially Submitted');
    }

    public function calculateTotalCarbonEmission()
    {
        $this->total_carbon_emission = 0;

        foreach ($this->bills as $bill) {
            $bill->calculateTotalCarbonEmission();
            $this->total_carbon_emission += $bill->total_carbon_emission;
        }

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
}
