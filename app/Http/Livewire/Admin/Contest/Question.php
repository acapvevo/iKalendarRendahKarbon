<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use App\Models\Competition;
use Illuminate\Validation\Rule;
use App\Models\Question as QuestionModel;

class Question extends Component
{
    public Competition $competition;
    public $questions;
    public QuestionModel $question;

    protected function rules()
    {
        return [
            'question.competition_id' => 'required|integer|exists:competitions,id',
            'question.text' => 'required|string|max:2048',
            'question.example' => 'required|string|max:2048',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($competition)
    {
        $this->competition = $competition;
        $this->questions = $competition->questions;
        $this->question = new QuestionModel([
            'competition_id' => $this->competition->id
        ]);
    }

    public function open($id = null)
    {
        if ($id) {
            $this->question = QuestionModel::find($id);
        } else {
            $this->question = new QuestionModel([
                'competition_id' => $this->competition->id
            ]);
        }
    }

    public function create()
    {
        $this->validate();

        $this->question->save();

        redirect(route('admin.contest.question.list'))->with('success', __("alerts.question_create", ['text' => $this->question->name]));
    }

    public function update()
    {
        $this->validate();

        $this->question->save();

        redirect(route('admin.contest.question.list'))->with('success', __("alerts.question_update", ['text' => $this->question->name]));
    }

    public function close()
    {
        $this->question = new QuestionModel([
            'competition_id' => $this->competition->id
        ]);
        $this->resetErrorBag();
    }

    public function delete($id)
    {
        $question = QuestionModel::find($id);
        $questionText = $question->text;

        $question->delete();

        redirect(route('admin.contest.question.list'))->with('success', __("alerts.question_delete", ['text' => $questionText]));
    }

    public function render()
    {
        return view('livewire.admin.contest.question');
    }
}
