<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use App\Models\Submission;
use App\Models\Competition;
use App\Traits\AddressTrait;
use App\Traits\SubmissionTrait;
use App\Traits\CompetitionTrait;
use App\Traits\Livewire\CheckGuard;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Winner extends Component
{
    use LivewireAlert, CheckGuard, CompetitionTrait, AddressTrait, SubmissionTrait;

    protected $guard = 'admin';

    public Competition $competition;
    public Submission $submission;

    public $address_category_list;

    public $submission_id;

    public $submissions;
    public $address_category;
    public $address_category_code;

    public $isLoading = false;

    protected function getListeners()
    {
        return [
            'closeModal' => 'close',
            'openModal' => 'open',
            'viewSubmission' => 'view',
            'changeCategory' => 'change',
        ];
    }

    protected function rules()
    {
        return [
            'address_category_code' => 'string|exists:address_category,code'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($competition)
    {
        $this->fill([
            'competition' => $competition,
            'address_category_list' => $this->getAddressCategories(),
            'submission' => $this->initSubmission()
        ]);

        $this->address_category = json_decode(json_encode($this->address_category_list->get(0)), true);
        $this->address_category_code = $this->address_category['code'];

        $this->submissions = $this->competition->getRankingByAddressCategory($this->address_category_code);
    }

    public function updateSubmissionId($submission_id)
    {
        $this->submission_id = $submission_id;

        $this->validate([
            'submission_id' => 'required|numeric|exists:submissions,id'
        ]);
    }

    public function change()
    {
        $this->address_category = json_decode(json_encode($this->getAddressCategory('code', $this->address_category_code)), true);
        $this->submissions = $this->competition->getRankingByAddressCategory($this->address_category_code);

        $this->dispatchBrowserEvent('updateTable', [
            'submissions' => $this->submissions
        ]);
    }

    public function open($submission_id)
    {
        $this->isLoading = true;

        $this->updateSubmissionId($submission_id);
        $this->submission = $this->getSubmission($submission_id);

        $this->isLoading = false;
    }

    public function close()
    {
        $this->fill([
            'submission' => $this->initSubmission()
        ]);
    }

    public function view($submission_id)
    {
        $this->updateSubmissionId($submission_id);
        return redirect(route('admin.contest.winner.view', ['submission_id' => $this->submission_id]));
    }

    public function render()
    {
        $this->address_category_list = $this->getAddressCategories();

        return view('livewire.admin.contest.winner');
    }
}
