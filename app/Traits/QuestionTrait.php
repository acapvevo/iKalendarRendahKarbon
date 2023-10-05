<?php

namespace App\Traits;

use App\Models\Question;

trait QuestionTrait
{
    use SubmissionTrait;

    public function getQuestion($id)
    {
        if ($id)
            return Question::find($id);
        else
            return new Question;
    }

    public function getCategories()
    {
        return $this->getSubmissionCategories();
    }
}
