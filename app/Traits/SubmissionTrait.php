<?php

namespace App\Traits;

use App\Models\Submission;

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
}
