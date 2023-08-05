<?php

namespace App\Http\Controllers\Admin\Contest;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Traits\CompetitionTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contest\Question\ViewQuestionsRequest;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    use CompetitionTrait;

    public function list(ViewQuestionsRequest $request)
    {
        $validated = $request->validated();

        $competition = $this->getCompetition($validated['competition_id']);
        $questions = $competition->questions;

        return view('admin.contest.question.list')->with([
            'competition' => $competition,
            'questions' => $questions,
        ]);
    }
}
