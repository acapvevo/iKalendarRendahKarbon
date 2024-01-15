<?php

namespace App\Http\Controllers\Admin\Analysis;

use App\Http\Controllers\Controller;
use App\Traits\ActivityTrait;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    use ActivityTrait;

    public function view(Request $request)
    {
        $request->validate([
            'year' => 'nullable|date_format:Y'
        ]);

        $years = $this->getYears();

        if ($request->has('year'))
            $year = $request->year;
        else
            $year = $years->get(0);

        return view('admin.analysis.activity.view')->with([
            'currentYear' => $year,
            'years' => $years,
        ]);
    }
}
