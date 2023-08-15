<?php

namespace App\Http\Livewire\Admin\Contest\Analysis;

use Livewire\Component;
use App\Models\Competition;
use App\Traits\CompetitionTrait;
use App\Traits\Livewire\CheckGuard;
use App\Traits\SubmissionTrait;
use App\Traits\ZoneTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Overall extends Component
{
    use LivewireAlert, CheckGuard, ZoneTrait, SubmissionTrait;

    protected $guard = 'admin';

    public Competition $competition;
    public $zones;

    public $carbon_emission_stats;
    public $submission_stats;
    public $submission_categories;

    public $isLoading = true;

    public $competition_id;

    protected function getListeners()
    {
        return [
            'initChartAndMap'
        ];
    }

    public function mount($competition)
    {
        $this->fill([
            'competition' => $competition,
            'competition_id' => $competition->id,
            'zones' => $this->getZones(),
        ]);
    }

    public function getAnalysis()
    {
        $this->carbon_emission_stats = $this->competition->getCarbonEmissionStats();
        $this->submission_stats = $this->competition->getSubmissionStats();

        [$total_carbon_emission_by_month, $total_carbon_emission_by_zone] = $this->carbon_emission_stats;
        [$total_submission_by_month, $total_submission_by_zone] = $this->submission_stats;

        $this->dispatchBrowserEvent('initChartAndMap', [
            'months' => $this->competition->getMonthNames(),
            'total_carbon_emission_by_month' => $total_carbon_emission_by_month,
            'total_submission_by_month' => $total_submission_by_month,
            'zones' => $this->zones,
            'total_carbon_emission_by_zone' => $total_carbon_emission_by_zone,
            'total_submission_by_zone' => $total_submission_by_zone,
        ]);

        $this->isLoading = false;
    }

    public function render()
    {
        $this->submission_categories = $this->getSubmissionCategories();

        return view('livewire.admin.contest.analysis.overall');
    }
}
