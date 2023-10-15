<?php

namespace App\Http\Livewire\Community;

use App\Models\Bill;
use App\Models\Competition;
use App\Models\Submission;
use App\Traits\BillTrait;
use App\Traits\CompetitionTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Traits\Livewire\CheckGuard;
use App\Traits\NewsletterTrait;
use App\Traits\SubmissionTrait;
use Livewire\Component;

class Dashboard extends Component
{
    use LivewireAlert, CheckGuard, NewsletterTrait, SubmissionTrait, CompetitionTrait, BillTrait;

    protected $guard = 'community';

    public $newsletters;
    public Submission $submission;
    public Competition $competition;
    public Bill $bill;

    public $newsletter_categories;
    public $submission_categories;

    protected function getListeners()
    {
        return [];
    }

    public function mount()
    {
        $this->competition = $this->getCurrentCompetition();

        $this->fill([
            'newsletter_categories' => $this->getNewsletterCategories(),
            'newsletters' => $this->getNewslettersForDashboard(),
            'submission_categories' => $this->getSubmissionCategories(),
            'submission' => $this->getSubmissionByCompetitionIDAndCommunityID($this->competition->id, request()->user('community')->id),
        ]);

        $this->bill = $this->getCurrentBillBySubmission($this->submission);
    }

    public function redirectNewsletter($newsletter_id)
    {
        return redirect(route('community.newsletter.view', ['id' => $newsletter_id]));
    }

    public function render()
    {
        return view('livewire.community.dashboard');
    }
}
