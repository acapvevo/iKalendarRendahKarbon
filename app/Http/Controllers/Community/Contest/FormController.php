<?php

namespace App\Http\Controllers\Community\Contest;

use App\Http\Controllers\Controller;
use App\Traits\CompetitionTrait;
use Illuminate\Http\Request;

class FormController extends Controller
{
    use CompetitionTrait;

    public function view()
    {
        $competition = $this->getCurrentCompetition();

        return view('community.form.view')->with([
            'competition' => $competition
        ]);
    }

    public function success()
    {

        return view('community.form.success');
    }
}
