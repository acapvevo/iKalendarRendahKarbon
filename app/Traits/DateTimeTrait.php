<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait DateTimeTrait
{
    public function getCurrentDate()
    {
        return Carbon::now();
    }

    public function getCurrentYear()
    {
        return Carbon::now()->year;
    }

    public function getCurrentMonth()
    {
        return Carbon::now()->month;
    }
}
