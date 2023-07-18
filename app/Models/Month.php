<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Month extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'num',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Get the Competiton that owns the Month.
     */
    public function competiton()
    {
        return $this->belongsTo(Competiton::class);
    }

    /**
     * Get the Bills associated with the Month.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function getName()
    {
        return Carbon::create(0, $this->num)->locale(LaravelLocalization::getCurrentLocale())->translatedFormat('F');
    }

    public function getUploadName()
    {
        return Carbon::create(0, $this->num)->format('F');
    }
}
