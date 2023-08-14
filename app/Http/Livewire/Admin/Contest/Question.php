<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use App\Models\Competition;
use App\Traits\Livewire\CheckGuard;
use Barryvdh\TranslationManager\Manager;
use App\Models\Question as QuestionModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Question extends Component
{
    use LivewireAlert, CheckGuard;

    protected $guard = 'admin';

    private $manager;

    public Competition $competition;
    public $questions;
    public QuestionModel $question;

    public $text_malay;
    public $example_malay;
    public $text_english;
    public $example_english;

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
            'text_malay' => 'required|string|max:2048',
            'example_malay' => 'required|string|max:2048',
            'text_english' => 'required|string|max:2048',
            'example_english' => 'required|string|max:2048',
            'question.category' => 'required|string|exists:submission_category,code',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function boot(Manager $manager)
    {
        $this->manager = $manager;
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

            $this->fill([
                'text_english' => $this->question->text,
                'example_english' => $this->question->example,
                'text_malay' => $this->question->getCurrentTranslation('text', null),
                'example_malay' => $this->question->getCurrentTranslation('example', null),
            ]);
        } else {
            $this->question = new QuestionModel([
                'competition_id' => $this->competition->id
            ]);

            $this->fill([
                'text_english' => '',
                'example_english' => '',
                'text_malay' => '',
                'example_malay' => '',
            ]);
        }
    }

    public function create()
    {
        $this->validate();

        $this->question->text = $this->text_english;
        $this->question->example = $this->example_english;
        $this->question->editTranslation($this->text_malay, $this->example_malay);

        $this->question->save();

        $this->manager->exportTranslations('_json', true);

        redirect(route('admin.contest.question.list', ['competition_id' => $this->competition->id]))->with('success', __("alerts.question_create", ['text' => $this->question->text]));
    }

    public function update()
    {
        $this->validate();

        // delete old translation
        $this->question->deleteTranslation();
        $this->manager->exportTranslations('_json', true);

        $this->question->text = $this->text_english;
        $this->question->example = $this->example_english;
        $this->question->editTranslation($this->text_malay, $this->example_malay);

        $this->question->save();

        $this->manager->exportTranslations('_json', true);

        redirect(route('admin.contest.question.list', ['competition_id' => $this->competition->id]))->with('success', __("alerts.question_update", ['text' => $this->question->text]));
    }

    public function close()
    {
        $this->question = new QuestionModel([
            'competition_id' => $this->competition->id
        ]);

        $this->reset([
            'text_english',
            'example_english',
            'text_malay',
            'example_malay',
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
            'text' => __("alerts.question_delete_confirmation", ['text' => $question->getValue('text')]),
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

        $question->deleteTranslation();

        $question->delete();

        $this->manager->exportTranslations('_json', true);

        redirect(route('admin.contest.question.list', ['competition_id' => $this->competition->id]))->with('success', __("alerts.question_delete"));
    }

    public function render()
    {
        return view('livewire.admin.contest.question');
    }
}
