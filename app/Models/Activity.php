<?php

namespace App\Models;

use App\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\Model;
use JamesMills\LaravelTimezone\Facades\Timezone;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory, ActivityTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'title',
        'total_carbon_emission'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date'
    ];

    /**
     * Get all of the Activity's Used Oil.
     */
    public function used_oil()
    {
        return $this->morphOne(UsedOil::class, 'parent');
    }

    /**
     * Get all of the Activity's Recycle.
     */
    public function recycle()
    {
        return $this->morphOne(Recycle::class, 'parent');
    }

    /**
     * Get all of the Activity's Fabric.
     */
    public function fabric()
    {
        return $this->morphOne(Fabric::class, 'parent');
    }

    /**
     * Get all of the Activity's Electronic.
     */
    public function electronic()
    {
        return $this->morphOne(Electronic::class, 'parent');
    }

    public function getAllActivityCategory()
    {
        return [
            'used_oil' => $this->used_oil,
            'recycle' => $this->recycle,
            'fabric' => $this->fabric,
            'electronic' => $this->electronic,
        ];
    }

    public function getDate()
    {
        return Timezone::convertToLocal($this->date, 'j F Y', true, true);
    }

    public function calculateTotalCarbonEmission()
    {
        $this->total_carbon_emission = ($this->fabric->carbon_emission ?? 0) + ($this->electronic->carbon_emission ?? 0) + ($this->recycle->carbon_emission ?? 0) + ($this->used_oil->carbon_emission ?? 0);
        $this->save();
    }

    public function deleteCategory()
    {
        foreach($this->getActivityCategories() as $category){
            $this->{$category->name}->delete();
        }
    }
}
