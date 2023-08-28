<?php

namespace App\Traits;

use App\Models\Question;

trait QuestionTrait
{
    public function getQuestion($id)
    {
        if ($id)
            return Question::find($id);
        else
            return new Question;
    }
}
