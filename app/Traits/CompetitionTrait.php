<?php

namespace App\Traits;

use App\Models\Competition;

trait CompetitionTrait
{
    public function getCompetitions()
    {
        return Competition::all()->sortByDesc('year');
    }

    public function getCompetition($id)
    {
        return Competition::find($id);
    }
}
