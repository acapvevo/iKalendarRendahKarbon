<?php

namespace App\Http\Controllers\Admin\Contest;

use App\Models\Question;
use App\Traits\CompetitionTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    use CompetitionTrait;

    public function list(Request $request)
    {
        $request->validate([
            'competition_id' => 'required|integer|exists:competitions,id'
        ]);

        $competition = $this->getCompetition($request->competition_id);
        $questions = $competition->questions;

        return view('admin.contest.question.list')->with([
            'competition' => $competition,
            'questions' => $questions,
            'attributes' => array_diff_key($request->all(), ["_token" => ''])
        ]);
    }
}
