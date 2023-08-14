<?php

namespace App\Http\Controllers\Admin;

use App\Models\Zone;
use App\Traits\ZoneTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZoneController extends Controller
{
    use ZoneTrait;

    public function list()
    {
        $zones = $this->getZones();

        return view('admin.zone.list')->with([
            'zones' => $zones
        ]);
    }
}
