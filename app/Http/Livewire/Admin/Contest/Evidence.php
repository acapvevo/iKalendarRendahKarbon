<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use App\Models\Submission;
use App\Traits\Livewire\CheckGuard;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Evidence extends Component
{
    use LivewireAlert, CheckGuard;

    protected $guard = 'admin';

    public Submission $submission;
    public $evidences;

    public function mount($submission)
    {
        $this->submission = $submission;
        $this->evidences = $submission->evidences;
    }

    public function render()
    {
        return view('livewire.admin.contest.evidence');
    }
}
