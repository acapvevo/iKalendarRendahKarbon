<?php

namespace App\Traits;

use App\Models\Month;

trait MonthTrait
{
    public function getMonth($id)
    {
        return Month::find($id);
    }
}
