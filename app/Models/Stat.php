<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'parent_type',

        'total_submission',
        'total_submission_each_month',
        'total_submission_each_zone',
        'total_submission_each_type_each_month',
        'total_submission_each_type_each_zone',
        'total_submission_each_type',
        'average_submission_by_month',
        'average_submission_by_zone',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'total_submission_each_month' => AsCollection::class,
        'total_submission_each_zone' => AsCollection::class,
        'total_submission_each_type' => AsCollection::class,
        'total_submission_each_type_each_month' => AsCollection::class,
        'total_submission_each_type_each_zone' => AsCollection::class,
    ];

    /**
     * Get the parent model (Submission, or Bill).
     */
    public function parent()
    {
        return $this->morphTo();
    }
}
