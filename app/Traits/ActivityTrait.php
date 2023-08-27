<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;

trait ActivityTrait
{
    public function getActivities()
    {
        return Activity::all()->sortByDesc('date');
    }

    public function getActivity($id)
    {
        if ($id)
            return Activity::find($id);
        else
            return new Activity;
    }

    public function getActivityCategories()
    {
        return DB::table('category')->where('forActivity', true)->get();
    }

    public function getActivityCategory($code)
    {
        return DB::table('category')->where('code', $code)->first();
    }

    public function initCalculationByActivityCategory()
    {
        return $this->getActivityCategories()->mapWithKeys(function ($category) {
            return [$category->name => 0];
        });
    }

    public function initModelByActivityCategory()
    {
        return $this->getActivityCategories()->mapWithKeys(function ($category) {
            return [$category->name => resolve($category->class, [
                'value' => 0,
                'weight' => 0
            ])];
        });
    }
}
