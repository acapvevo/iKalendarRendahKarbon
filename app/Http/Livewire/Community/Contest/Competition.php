<?php

namespace App\Http\Livewire\Community\Contest;

use Livewire\Component;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Competition as CompetitionModel;

class Competition extends Component
{
    use LivewireAlert;

    public $competitions;
    public CompetitionModel $competition;
    public $submission;

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

    public function mount($competitions)
    {
        $this->competitions = $competitions;
        $this->competition = new CompetitionModel;
        $this->submission = new Submission;
    }

    public function open($id)
    {
        $this->competition = CompetitionModel::find($id);
        $this->submission = $this->competition->getSubmissionByUserID(Auth::user()->id);

        if ($this->submission) {
            $this->submission->calculateTotalCarbonEmission();
        }
    }

    public function close()
    {
        $this->competition = new CompetitionModel;
        $this->submission = new Submission;
    }

    public function render()
    {
        return view('livewire.community.contest.competition');
    }
}
