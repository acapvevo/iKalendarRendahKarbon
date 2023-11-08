<?php

namespace App\Traits;

use App\Models\Stat;

trait StatTrait
{
    public function getStatByClassAndID($id, $class)
    {
        return Stat::firstOrNew([
            'parent_id' => $id,
            'parent_type' => $class,
        ]);
    }
}
