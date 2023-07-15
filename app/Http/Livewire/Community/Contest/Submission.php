<?php

namespace App\Http\Livewire\Community\Contest;

use App\Models\Bill;
use Livewire\Component;
use App\Models\Submission as SubmissionModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Submission extends Component
{
    use LivewireAlert;

    public SubmissionModel $submission;
    public Bill $bill;

    public function listener()
    {
        return [];
    }

    protected function rules()
    {
        return [];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($submission)
    {
        $this->submission = $submission;
    }

    public function open($id)
    {
        $this->submission = SubmissionModel::find($id);
    }

    public function close()
    {
        $this->submission = new SubmissionModel;
    }

    public function render()
    {
        return view('livewire.community.contest.submission');
    }
}
