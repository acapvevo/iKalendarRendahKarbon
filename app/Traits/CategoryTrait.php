<?php

namespace App\Traits;

use App\Models\Water;
use App\Models\Recycle;
use App\Models\UsedOil;
use App\Models\Electric;
use Illuminate\Support\Facades\DB;

trait CategoryTrait
{
    public function getCategories()
    {
        return DB::table('category')->get();
    }

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
