<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_id',
        'question_id',
        'text',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Get the Question that owns the Month.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the Submission that owns the Month.
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
