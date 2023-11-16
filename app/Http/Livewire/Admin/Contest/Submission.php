<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use App\Models\Competition;
use App\Traits\Livewire\CheckGuard;
use App\Models\Submission as SubmissionModel;
use App\Traits\SubmissionTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Submission extends Component
{
    use LivewireAlert, CheckGuard, SubmissionTrait;

    protected $guard = 'admin';

    public $competition_id;
    public $submission_id;

    public SubmissionModel $submission;

    protected $listeners = [
        'openModal' => 'open',
        'closeModal' => 'close',
    ];

    public function mount($competition_id)
    {
        $this->competition_id = $competition_id;
    }

    public function getSubmissionProperty()
    {
        return $this->getSubmission($this->submission_id);
    }

    public function open($submission_id)
    {
        $this->submission_id = $submission_id;
        $this->submission = $this->getSubmissionProperty();
    }

    public function close()
    {
        $this->submission_id = null;
        $this->submission = $this->initSubmission();
    }

    public function render()
    {
        return view('livewire.admin.contest.submission');
    }
}
