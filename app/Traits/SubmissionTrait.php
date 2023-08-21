<?php

namespace App\Traits;

use App\Models\Submission;
use Illuminate\Support\Facades\DB;

trait SubmissionTrait
{
    public function getSubmission($id)
    {
        return Submission::find($id);
    }

    public function getSubmissionByCompetitionIDAndCommunityID($competition_id, $community_id)
    {
        return Submission::firstOrNew([
            'competition_id' => $competition_id,
            'community_id' => $community_id
        ]);
    }

    public function getSubmissionCategories($type = 'competition')
    {
        switch ($type) {
            case 'competition':
                return DB::table('submission_category')->where('forCompetition', true)->get();

            case 'activity':
                return DB::table('submission_category')->where('forActivity', true)->get();

            case 'all':
                return DB::table('submission_category')->get();
        }
    }

    public function initCalculationBySubmissionCategory()
    {
        return $this->getSubmissionCategories()->mapWithKeys(function ($category) {
            return [$category->name => 0];
        });
    }
}
