<?php

namespace App\Traits;

use App\Models\Competition;

trait CompetitionTrait
{
    public function getCompetition($id)
    {
        return Competition::find($id);
    }
}
