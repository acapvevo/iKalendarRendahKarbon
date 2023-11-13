<?php

namespace App\Traits;

use App\Models\Month;

trait MonthTrait
{
    use DateTimeTrait;

    public function getMonth($id)
    {
        return Month::find($id);
    }

    public function getMonthsByCompetitionID($competition_id)
    {
        return Month::where('competition_id', $competition_id)->get();
    }

    public function getCurrentMonthByCompetitionID($competition_id)
    {
        $currentMonth = $this->getCurrentMonth();

        return Month::firstOrNew([
            'num' => $currentMonth,
            'competition_id' => $competition_id
        ]);
    }
}
