<?php

namespace App\Traits;

use App\Models\Zone;

trait ZoneTrait
{
    public function getZones()
    {
        return Zone::all();
    }

    public function getZone($id)
    {
        return Zone::find($id);
    }

    public function initCalculationByZone()
    {
        return $this->getZones()->mapWithKeys(function ($zone) {
            return [$zone['id'] => 0];
        })->toArray();
    }
}
