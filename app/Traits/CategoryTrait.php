<?php

namespace App\Traits;

use App\Models\Electric;
use App\Models\Recycle;
use App\Models\UsedOil;
use App\Models\Water;

trait CategoryTrait
{
    public function getCategoryByBill($category_code, $bill_id)
    {
        switch ($category_code) {
            case 'E':
                return Electric::firstOrNew([
                    'parent_id' => $bill_id,
                    'parent_type' => 'App\Models\Bill'
                ]);
            case 'W':
                return Water::firstOrNew([
                    'parent_id' => $bill_id,
                    'parent_type' => 'App\Models\Bill'
                ]);
            case 'R':
                return Recycle::firstOrNew([
                    'parent_id' => $bill_id,
                    'parent_type' => 'App\Models\Bill'
                ]);
            case 'UO':
                return UsedOil::firstOrNew([
                    'parent_id' => $bill_id,
                    'parent_type' => 'App\Models\Bill'
                ]);
        }
    }
}
