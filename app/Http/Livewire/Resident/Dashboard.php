<?php

namespace App\Http\Livewire\Resident;

use Livewire\Component;
use App\Traits\BillTrait;
use App\Traits\NewsletterTrait;
use App\Traits\SubmissionTrait;
use App\Traits\CompetitionTrait;
use App\Traits\Livewire\CheckGuard;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Dashboard extends Component
{
    use LivewireAlert, CheckGuard, NewsletterTrait, SubmissionTrait, CompetitionTrait, BillTrait;

    protected $guard = 'resident';

    public $newsletters;
    // public Submission $submission;
    // public Competition $competition;
    // public Bill $bill;

    public $newsletter_categories;
    public $submission_categories;

    protected function getListeners()
    {
        return [];
    }

    public function mount()
    {
        // $this->competition = $this->getCurrentCompetition();

        $this->fill([
            'newsletter_categories' => $this->getNewsletterCategories(),
            'newsletters' => $this->getNewslettersForDashboard(),
            // 'submission_categories' => $this->getSubmissionCategories(),
            // 'submission' => $this->getSubmissionByCompetitionIDAndCommunityID($this->competition->id, request()->user('resident')->id),
        ]);

        // $this->bill = $this->getCurrentBillBySubmission($this->submission);
    }

    public function redirectNewsletter($newsletter_id)
    {
        return redirect(route('resident.newsletter.view', ['id' => $newsletter_id]));
    }

    public function render()
    {
        return view('livewire.resident.dashboard');
    }
}
