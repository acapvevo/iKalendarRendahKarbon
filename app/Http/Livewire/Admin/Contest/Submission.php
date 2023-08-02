<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use App\Models\Competition;
use App\Traits\Livewire\CheckGuard;
use App\Models\Submission as SubmissionModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Submission extends Component
{
    use LivewireAlert, CheckGuard;

    protected $guard = 'admin';

    public $competition_id;
    public $submission_id;

    public SubmissionModel $submission;

    protected $listeners = ['openModal' => 'open'];

    public function mount($competition_id)
    {
        $this->competition_id = $competition_id;
    }

    public function getSubmissionProperty()
    {
        return SubmissionModel::find($this->submission_id);
    }

    public function open($submission_id)
    {
        $this->submission_id = $submission_id;

        $this->submission = $this->getSubmissionProperty();
    }

    public function close()
    {
        $this->submission = new SubmissionModel;
    }

    public function render()
    {
        return view('livewire.admin.contest.submission');
    }
}
