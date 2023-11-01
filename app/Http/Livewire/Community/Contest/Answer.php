<?php

namespace App\Http\Livewire\Community\Contest;

use Livewire\Component;
use App\Models\Question;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;
use App\Traits\Livewire\CheckGuard;
use App\Models\Answer as AnswerModel;
use App\Traits\QuestionTrait;
use App\Traits\SubmissionTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Answer extends Component
{
    use LivewireAlert, CheckGuard, SubmissionTrait, QuestionTrait;

    protected $guard = 'community';

    public $community_id;
    public $competition_id;
    public $submission_id;
    public $question_id;

    public $category_name;
    public $category_description;
    public $category_code;

    public Submission $submission;
    public $questions;
    public Question $question;
    public AnswerModel $answer;

    protected function rules()
    {
        return [
            'answer.text' => 'required|string|max:2048'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($submission, $category)
    {
        $this->submission_id = $submission->id;
        $this->competition_id = $submission->competition_id;
        $this->community_id = $submission->community_id;

        $this->fill([
            'submission' => $this->getSubmissionProperty(),
            'question' => new Question,
            'answer' => new AnswerModel,
        ]);

        $category_obj = $this->getSubmissionCategoryByCode($category);

        $this->fill([
            'category_name' => $category_obj->name,
            'category_description' => $category_obj->description,
            'category_code' => $category_obj->code,
            'questions' => $submission->competition->getQuestionsByCategory($category_obj->code)
        ]);
    }

    public function getSubmissionProperty()
    {
        return $this->getSubmission($this->submission_id);
    }

    public function getQuestionProperty()
    {
        return $this->getQuestion($this->question_id);
    }

    public function getAnswerProperty()
    {
        return $this->submission->getAnswerByQuestionID($this->question_id);
    }

    public function open($question_id)
    {
        $this->question_id = $question_id;

        $this->question = $this->getQuestionProperty();
        $this->answer = $this->getAnswerProperty();
    }

    public function close()
    {
        $this->fill([
            'answer' => new AnswerModel([
                'submission_id' => $this->submission_id
            ])
        ]);

        $this->resetErrorBag();
    }

    public function update()
    {
        $this->validate();

        if (!$this->answer->submission_id || !$this->answer->question_id) {
            $this->answer->submission_id = $this->submission_id;
            $this->answer->question_id = $this->question_id;
        }

        $this->answer->save();

        redirect(route('community.contest.submission.list', ['competition_id' => $this->competition_id, 'category' => $this->category_code]))->with('success', __('alerts.answer_update', ['question' => $this->question->getValue('text')]));
    }

    public function render()
    {
        return view('livewire.community.contest.answer');
    }
}
