<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use App\Models\Submission;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Answer extends Component
{
    use LivewireAlert;

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
