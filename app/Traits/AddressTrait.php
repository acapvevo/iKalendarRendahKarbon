<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait AddressTrait
{
    public function getAddressCategories()
    {
        return DB::table('address_category')->get();
    }

    public function getAddressCategory($column, $value)
    {
        return DB::table('address_category')->where($column, $value)->first();
    }
}
