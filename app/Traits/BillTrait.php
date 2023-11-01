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
    
    public function getBillByMonthAndSubmission($month_id, $submission_id)
    {
        return Bill::firstOrNew([
            'submission_id' => $submission_id,
            'month_id' => $month_id
        ]);
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
