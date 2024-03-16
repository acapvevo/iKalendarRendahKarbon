<?php

namespace App\Traits;

use App\Models\Competition;

trait CompetitionTrait
{
    use DateTimeTrait;

    public function getCompetitions()
    {
        return Competition::all()->sortByDesc('year');
    }

    public function getCompetition($id)
    {
        return Competition::find($id);
    }

    public function getCurrentCompetition()
    {
        $currentDate = $this->getCurrentDate();

        if ($currentDate->month <= 3)
            return $this->getCompetitions()->last();
        else
            $year = $currentDate->year;

        return Competition::firstOrNew([
            'year' => $year
        ]);
    }

    public function getCompetitionByYear($year)
    {
        return Competition::firstOrNew([
            'year' => $year
        ]);
    }

    public function initCompetition()
    {
        return new Competition;
    }
}
