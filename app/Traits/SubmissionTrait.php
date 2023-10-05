<?php

namespace App\Traits;

use App\Models\Submission;
use Illuminate\Support\Facades\DB;

trait SubmissionTrait
{
    public function getSubmission($id)
    {
        if ($id)
            return Submission::find($id);
        else
            return new Submission;
    }

    public function getAllSubmissions()
    {
        return Submission::all();
    }

    public function getSubmissionByCompetitionIDAndCommunityID($competition_id, $community_id)
    {
        return Submission::firstOrNew([
            'competition_id' => $competition_id,
            'community_id' => $community_id
        ]);
    }

    public function getSubmissionsByCompetitionID($competition_id)
    {
        return Submission::where('competition_id', $competition_id)->get();
    }

    public function getSubmissionCategories()
    {
        return DB::table('category')->where('forCompetition', true)->get();
    }

    public function getSubmissionCategory($code)
    {
        return DB::table('category')->where('code', $code)->first();
    }

    public function initCalculationBySubmissionCategory()
    {
        return $this->getSubmissionCategories()->mapWithKeys(function ($category) {
            return [$category->name => 0];
        })->toArray();
    }
}
