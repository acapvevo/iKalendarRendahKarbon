<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use App\Models\Submission;
use App\Traits\Livewire\CheckGuard;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Answer extends Component
{
    use LivewireAlert, CheckGuard;

    protected $guard = 'admin';

    public $submission_id;

    public Submission $submission;

    public function mount($submission)
    {
        $this->submission_id = $submission->id;
        $this->submission = $submission;
    }

    public function render()
    {
        return view('livewire.admin.contest.answer');
    }
}
