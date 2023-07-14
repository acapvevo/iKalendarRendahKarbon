<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use App\Models\Competition;
use Illuminate\Validation\Rule;
use App\Models\Question as QuestionModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Question extends Component
{
    use LivewireAlert;

    public Competition $competition;
    public $questions;
    public QuestionModel $question;

    public function getListeners()
    {
        return [
            'delete'
        ];
    }

    protected function rules()
    {
        return [
            'question.competition_id' => 'required|integer|exists:competitions,id',
            'question.text' => 'required|string|max:2048',
            'question.example' => 'required|string|max:2048',
            'question.category' => 'required|string|exists:question_category,code',
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

        redirect(route('admin.contest.question.list', ['competition_id' => $this->competition->id]))->with('success', __("alerts.question_create", ['text' => $this->question->text]));
    }

    public function update()
    {
        $this->validate();

        $this->question->save();

        redirect(route('admin.contest.question.list', ['competition_id' => $this->competition->id]))->with('success', __("alerts.question_update", ['text' => $this->question->text]));
    }

    public function close()
    {
        $this->question = new QuestionModel([
            'competition_id' => $this->competition->id
        ]);
        $this->resetErrorBag();
    }

    public function askDelete($id)
    {
        $question = QuestionModel::find($id);

        $this->alert('warning', __('Warning'), [
            'inputAttributes' => [
                'id' => $id
             ],
            'position' => 'center',
            'timer' => null,
            'toast' => true,
            'text' => __("alerts.question_delete_confirmation", ['text' => $question->text]),
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'cancelButtonText' => __('Cancel'),
            'confirmButtonText' => __('Confirm'),
            'onConfirmed' => 'delete',
            'onDismissed' => '',
        ]);
    }

    public function delete($response)
    {
        $question = QuestionModel::find($response['data']['inputAttributes']['id']);

        $question->delete();

        redirect(route('admin.contest.question.list', ['competition_id' => $this->competition->id]))->with('success', __("alerts.question_delete"));
    }

    public function render()
    {
        return view('livewire.admin.contest.question');
    }
}
