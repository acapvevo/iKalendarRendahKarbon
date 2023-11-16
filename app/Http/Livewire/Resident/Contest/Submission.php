<?php

namespace App\Http\Livewire\Resident\Contest;

use App\Models\Competition;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Traits\Livewire\CheckGuard;
use App\Models\Submission as SubmissionModel;
use App\Traits\CompetitionTrait;
use App\Traits\SubmissionTrait;
use Livewire\Component;

class Submission extends Component
{
    use LivewireAlert, CheckGuard, SubmissionTrait, CompetitionTrait;

    protected $guard = 'resident';

    public $competition_id;
    public $submission_id;

    public SubmissionModel $submission;
    public Competition $competition;

    public $community_selection;

    protected function getListeners()
    {
        return [
            'openModal' => 'open',
            'closeModal' => 'close',
            'viewSubmission' => 'view',
        ];
    }

    protected function rules()
    {
        return [
            'community_selection' => 'array',
            'community_selection.*' => 'numeric|exists:communities,id',
        ];
    }

    public function mount($competition_id)
    {
        $this->competition_id = $competition_id;
        $this->competition = $this->getCompetitionProperty();
    }

    public function getCompetitionProperty()
    {
        return $this->getCompetition($this->competition_id);
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

    public function add()
    {
        $this->validate([
            'community_selection' => 'required'
        ]);

        foreach ($this->community_selection as $community_id) {
            $submission = $this->getSubmissionByCompetitionIDAndCommunityID($this->competition_id, $community_id);

            $submission->save();
        }

        return redirect(route('resident.contest.submission.list', ['competition_id' => $this->competition_id]))->with('success', __("alerts.comunity_add"));
    }

    public function view($submission_id)
    {
        return redirect(route('resident.contest.submission.category', ['submission_id' => $submission_id]));
    }

    public function render()
    {
        return view('livewire.resident.contest.submission');
    }
}
