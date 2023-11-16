<?php

namespace App\Http\Livewire\Resident\Contest;

use Livewire\Component;
use App\Models\Submission;
use App\Traits\EvidenceTrait;
use Livewire\WithFileUploads;
use App\Traits\SubmissionTrait;
use Illuminate\Validation\Rule;
use App\Traits\Livewire\CheckGuard;
use App\Models\Evidence as EvidenceModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Evidence extends Component
{
    use LivewireAlert, CheckGuard, WithFileUploads, SubmissionTrait, EvidenceTrait;

    protected $guard = 'resident';

    public EvidenceModel $evidence;
    public Submission $submission;
    public $evidences;

    public $evidence_id;
    public $submission_id;
    public $competition_id;

    public $category_name;
    public $category_description;
    public $category_code;

    public $file;
    public $file_label;

    protected function getListeners()
    {
        return [
            'delete',
            'closeModal' => 'close',
        ];
    }

    protected function rules()
    {
        return [
            'evidence.title' => 'string|max:255',
            'file' => 'mimes:jpg,pdf,png,doc,docx|max:4096'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($submission, $category)
    {
        $this->competition_id = $submission->competition_id;
        $this->submission_id = $submission->id;

        $this->fill([
            'submission' => $this->getSubmissionProperty(),
            'evidence' => $this->getEvidenceProperty(),
            'file_label' => __("Upload your Evidence File")
        ]);

        $category_obj = $this->getSubmissionCategoryByCode($category);
        $this->fill([
            'category_name' => $category_obj->name,
            'category_description' => $category_obj->description,
            'category_code' => $category_obj->code,
        ]);

        $this->evidences = $this->submission->getEvidensByCategory($category_obj->code);
    }

    public function getEvidenceProperty()
    {
        return $this->getEvidence($this->evidence_id);
    }

    public function getSubmissionProperty()
    {
        return $this->getSubmission($this->submission_id);
    }

    public function changePlaceholder()
    {
        $file = $this->file;
        $this->file_label = $file ? $file->getClientOriginalName()  : __('Upload your Evidence File');
    }

    public function open($id)
    {
        $this->evidence_id = $id;
        $this->evidence = $this->getEvidenceProperty();
    }

    public function close()
    {
        $this->fill([
            'evidence_id' => null,
            'evidence' => $this->getEvidenceProperty(),
            'file' => null,
            'fileLabel' => __("Upload your Evidence File"),
        ]);
    }

    public function create()
    {
        $this->validate([
            'evidence.title' => 'required',
            'file' => 'required'
        ]);

        $this->evidence->submission_id = $this->submission_id;
        $this->evidence->category = $this->category_code;
        $this->evidence->file = $this->evidence->formatTitleForFileName($this->category_name) . '.' . $this->file->getClientOriginalExtension();
        $this->file->storeAs($this->evidence->getFilePath(), $this->evidence->file);

        $this->evidence->save();

        return redirect(route('resident.contest.submission.view', ['submission_id' => $this->submission_id, 'category' => $this->category_code]))->with('success', __('alerts.evidence_create', ['title' => $this->evidence->title, 'category' => __($this->category_description)]));
    }

    public function update()
    {
        $this->validate([
            'evidence.title' => 'required',
            'file' => Rule::requiredIf(fn () => !isset($this->evidence->file))
        ]);

        if (isset($this->file)) {
            $this->evidence->file = $this->evidence->formatTitleForFileName($this->category_name) . '.' . $this->file->getClientOriginalExtension();
            $this->file->storeAs($this->evidence->getFilePath(), $this->evidence->file);
        }

        $this->evidence->save();

        return redirect(route('resident.contest.submission.view', ['submission_id' => $this->submission_id, 'category' => $this->category_code]))->with('success', __('alerts.evidence_update', ['title' => $this->evidence->title, 'category' => __($this->category_description)]));
    }

    public function askDelete($id)
    {
        $evidence = $this->getEvidence($id);

        $this->alert('warning', __('Warning'), [
            'inputAttributes' => [
                'id' => $id
            ],
            'position' => 'center',
            'timer' => null,
            'toast' => true,
            'text' => __("alerts.evidence_delete_confirmation", ['title' => $evidence->title, 'category' => __($this->category_description)]),
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
        $evidence = $this->getEvidence($response['data']['inputAttributes']['id']);

        $evidence->deleteFile();

        $evidence->delete();

        redirect(route('resident.contest.submission.view', ['submission_id' => $this->submission_id, 'category' => $this->category_code]))->with('success', __("alerts.evidence_delete"));
    }

    public function render()
    {
        $this->changePlaceholder();

        return view('livewire.resident.contest.evidence');
    }
}
