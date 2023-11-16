<?php

namespace App\Traits;

use App\Models\Submission;
use Illuminate\Support\Facades\DB;

trait SubmissionTrait
{
    use ZoneTrait;

    public function initSubmission()
    {
        return new Submission;
    }

    public function getSubmission($id)
    {
        if ($id)
            return Submission::find($id);
        else
            return new Submission;
    }

    public function getSubmissions()
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

    public function checkSubmissionCategory($column, $value)
    {
        return DB::table('category')->where('forCompetition', true)->where($column, $value)->exists();
    }

    public function getSubmissionCategories()
    {
        return DB::table('category')->where('forCompetition', true)->get();
    }

    public function getSubmissionCategory($column, $value)
    {
        return DB::table('category')->where($column, $value)->first();
    }

    public function getSubmissionCategoryByCode($code)
    {
        return DB::table('category')->where('code', $code)->first();
    }

    public function getSubmissionCategoryClass($code, $bill)
    {
        $category = $this->getSubmissionCategoryByCode($code);

        if ($bill->{$category->name})
            return $bill->{$category->name};
        else
            return resolve($category->class, [
                'bill_id' => $bill->id
            ]);
    }

    public function initCalculationBySubmissionCategory()
    {
        return $this->getSubmissionCategories()->mapWithKeys(function ($category) {
            return [$category->name => 0];
        })->toArray();
    }

    public function initCalculationEachMonth($competition)
    {
        return $competition->months->mapWithKeys(function ($month) {
            return [$month->id => 0];
        })->toArray();
    }

    public function initCalculationEachZone()
    {
        return $this->getZones()->mapWithKeys(function ($zone) {
            return [$zone->id => 0];
        })->toArray();
    }

    public function initCalculationBySubmissionCategoryEachMonth($competition)
    {
        return $competition->months->mapWithKeys(function ($month) {
            return [
                $month->id => $this->getSubmissionCategories()->mapWithKeys(function ($category) {
                    return [$category->name => 0];
                })->toArray()
            ];
        })->toArray();
    }

    public function initCalculationBySubmissionCategoryEachZone()
    {
        return $this->getZones()->mapWithKeys(function ($zone) {
            return [
                $zone->id => $this->getSubmissionCategories()->mapWithKeys(function ($category) {
                    return [$category->name => 0];
                })->toArray()
            ];
        })->toArray();
    }
}
