<?php

namespace App\Traits;

use App\Models\Evidence;

trait EvidenceTrait
{
    public function getEvidence($id)
    {
        if ($id)
            return Evidence::find($id);
        else
            return new Evidence;
    }
}
