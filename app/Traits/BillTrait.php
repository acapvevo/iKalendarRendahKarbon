<?php

namespace App\Traits;

use App\Models\Bill;

trait BillTrait
{
    use MonthTrait;

    public function getBill($id)
    {
        return Bill::find($id);
    }

    public function getBillByMonth($month_id)
    {
        return Bill::where('month_id', $month_id)->first();
    }

    public function getCurrentBillBySubmission($submission)
    {
        $currentMonth = $this->getCurrentMonthByCompetitionID($submission->competition_id);

        return Bill::firstOrNew([
            'submission_id' => $submission->id,
            'month_id' => $currentMonth->id
        ]);
    }
}
