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
        foreach ($this->bills as $index => $bill) {
            if (!$bill->isDoneSubmit()) {
                if ($index == 0)
                    return __('Not Submitted');
                else
                    return __('Partial Submitted');
            }

            return __('Fully Submitted');
        }
    }

    public function calculateTotalCarbonEmission()
    {
        $this->totalCarbonEmission = 0;

        foreach ($this->bills as $bill) {
            $bill->calculateTotalCarbonEmission();
            $this->total_carbon_emission += $bill->total_carbon_emission;
        }

        $this->save();
    }
}
