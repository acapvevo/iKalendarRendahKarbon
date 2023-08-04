<?php

namespace App\Traits;

use App\Models\Admin;

trait AdminTrait
{
    public function getAdmin($id)
    {
        return Admin::find($id);
    }
}
