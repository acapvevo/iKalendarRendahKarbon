<?php

namespace App\Traits;

use App\Models\Bill;

trait BillTrait
{
    public function getBill($id)
    {
        return Bill::find($id);
    }
}
