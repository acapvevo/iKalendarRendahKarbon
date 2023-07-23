<?php

namespace App\Http\Livewire\Community\Contest;

use Livewire\Component;
use App\Models\Question;
use App\Models\Submission;
use App\Models\Answer as AnswerModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Answer extends Component
{
    use LivewireAlert;

    public $community_id;
    public $competition_id;
    public $submission_id;
    public $question_id;

    public Submission $submission;
    public Question $question;
    public AnswerModel $answer;

    public $tab_state = 0;
    public $questionCategoryList;

    protected function listener()
    {
        return [
            'changeTabAnswer' =>  'changeTab'
        ];
    }

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

    public function mount($submission)
    {
        $this->submission_id = $submission->id;
        $this->competition_id = $submission->competition_id;
        $this->community_id = $submission->community_id;

        $this->fill([
            'submission' => $this->getSubmissionProperty(),
            'question' => new Question,
            'answer' => new AnswerModel
        ]);

        $this->questionCategoryList = $this->submission->competition->getQuestionCategories();
    }

    public function getSubmissionProperty()
    {
        return $this->submission_id ? Submission::find($this->submission_id) : new Submission([
            'competition_id' => $this->competition_id,
            'community_id' => $this->community_id,
        ]);
    }

    public function getQuestionProperty()
    {
        return Question::find($this->question_id);
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

        if (!$this->answer->submission_id || !$this->answer->question_id){
            $this->answer->submission_id = $this->submission_id;
            $this->answer->question_id = $this->question_id;
        }

        $this->answer->save();

        redirect(route('community.contest.submission.list', ['competition_id' => $this->competition_id]))->with('success', __('alerts.answer_update', ['question' => $this->question->getValue('text')]));
    }

    public function render()
    {
        return view('livewire.community.contest.answer');
    }
}
