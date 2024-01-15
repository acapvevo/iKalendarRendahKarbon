<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;

trait ActivityTrait
{
    public function getYears()
    {
        return Activity::selectRaw('YEAR(date) as year')->distinct()->get()->sortByDesc('year')->pluck('year');
    }

    public function getActivities()
    {
        return Activity::orderBy('date', 'desc')
            ->get();
    }

    public function getActivity($id)
    {
        if ($id)
            return Activity::find($id);
        else
            return new Activity;
    }

    public function getActivitiesByYear($year)
    {
        return Activity::whereYear('date', $year)->get();
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
        })->toArray();
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

    public function getAnalysisByYear($year)
    {
        $activities = $this->getActivitiesByYear($year);
        $categories = $this->getActivityCategories();

        $total_carbon_emission = $total_weight = $total_value = 0;
        $total_carbon_emission_each_category = $total_weight_each_category = $total_value_each_category = $this->initCalculationByActivityCategory();

        foreach ($activities as $activity) {
            $total_carbon_emission += $activity->total_carbon_emission;

            foreach ($categories as $category) {
                $total_weight += $activity->{$category->name}->weight;
                $total_weight_each_category[$category->name] += $activity->{$category->name}->weight;

                $total_value += $activity->{$category->name}->value;
                $total_value_each_category[$category->name] += $activity->{$category->name}->value;

                $total_carbon_emission_each_category[$category->name] += $activity->{$category->name}->carbon_emission;
            }
        }

        return [
            'total_carbon_emission' => $total_carbon_emission,
            'total_weight' => $total_weight,
            'total_value' => $total_value,
            'total_carbon_emission_each_category' => $total_carbon_emission_each_category,
            'total_weight_each_category' => $total_weight_each_category,
            'total_value_each_category' => $total_value_each_category,
        ];
    }
}
