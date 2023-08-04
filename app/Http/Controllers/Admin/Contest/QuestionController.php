<?php

namespace App\Http\Controllers\Admin\Contest;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Traits\CompetitionTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    use CompetitionTrait;

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'competition_id' => 'required|integer|exists:competitions,id'
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.contest.competition.list'))
                    ->withErrors($validator);
        }

        $competition = $this->getCompetition($request->competition_id);
        $questions = $competition->questions;

        return view('admin.contest.question.list')->with([
            'competition' => $competition,
            'questions' => $questions,
            'attributes' => array_diff_key($request->all(), ["_token" => ''])
        ]);
    }
}
