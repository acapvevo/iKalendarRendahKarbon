<?php

namespace App\Traits;

use App\Models\Calculation;

trait CalculationTrait
{
    use SubmissionTrait;

    public function getCalculationByClassAndID($id, $class)
    {
        return Calculation::firstOrNew([
            'parent_id' => $id,
            'parent_type' => $class,
        ]);
    }

    public function checkCalculationByClassAndID($id, $class)
    {
        return Calculation::where('parent_id', $id)->where('parent_type', $class)->exists();
    }

    public function initCalculation()
    {
        $calculation = new Calculation;

        $calculation->total_carbon_emission = $calculation->total_charge = $calculation->total_usage = $calculation->total_weight = $calculation->total_value = 0;
        $calculation->total_carbon_reduction = $calculation->total_usage_reduction = $calculation->total_charge_reduction = 0;

        $calculation->total_carbon_emission_each_type = $calculation->total_usage_each_type = $calculation->total_charge_each_type = $calculation->total_weight_each_type = $calculation->total_value_each_type = $calculation->this->initCalculationBySubmissionCategory();
        $calculation->total_carbon_reduction_each_type = $calculation->usage_reduction_each_type = $calculation->charge_reduction_each_type = $this->initCalculationBySubmissionCategory();

        return $calculation;
    }
}
