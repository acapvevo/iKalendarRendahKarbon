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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Get the Community that owns the Submission.
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
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
}
