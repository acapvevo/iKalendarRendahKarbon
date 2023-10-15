<?php

namespace App\Traits;

use App\Models\Calculation;

trait CalculationTrait
{
    public function getCalculationByClassAndID($id, $class)
    {
        return Calculation::firstOrNew([
            'parent_id' => $id,
            'parent_type' => $class,
        ]);
    }
}
