<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'text',
        'example',
        'category',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the Competition that owns the Question.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * Get the Answers associated with the Question.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getCategory()
    {
        return DB::table('question_category')->where('code', $this->category)->first();
    }
}
