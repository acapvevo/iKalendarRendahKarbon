<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ActivityTrait;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    use ActivityTrait;

    public function list()
    {
        $activities = $this->getActivities();

        return view('admin.activity.list')->with([
            'activities' => $activities
        ]);
    }
}
