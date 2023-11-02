<?php

namespace App\Http\Livewire\Community\Contest;

use Livewire\Component;
use App\Models\Submission;
use App\Traits\Livewire\CheckGuard;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Competition as CompetitionModel;

class Competition extends Component
{
    use LivewireAlert, CheckGuard;

    protected $guard = 'community';

    public $competitions;
    public CompetitionModel $competition;
    public $submission;

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
        $this->submission = $this->competition->getSubmissionByCommunityID(Auth::user()->id);

        if ($this->submission) {
            $this->submission->calculateTotalCarbonEmission();
        }
    }

    public function close()
    {
        $this->competition = new CompetitionModel;
        $this->submission = new Submission;

        $this->resetErrorBag();
    }

    public function view($competition_id)
    {
        return redirect(route('community.contest.submission.category', ['competition_id' => $competition_id]));
    }

    public function render()
    {
        return view('livewire.community.contest.competition');
    }
}
