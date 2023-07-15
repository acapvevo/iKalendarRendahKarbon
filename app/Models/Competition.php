<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

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

    public function checkSubmissionStatus($user_id)
    {
        $submission = $this->getSubmissionByUserID($user_id);

        if ($submission) {
            return $submission->checkBillsSubmit();
        } else {
            return __('Not Submitted');
        }
    }

    public function getSubmissionByUserID($user_id)
    {
        return $this->submissions->where('user_id', $user_id)->first();

    }
}
