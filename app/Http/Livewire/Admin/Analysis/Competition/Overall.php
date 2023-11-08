<?php

namespace App\Http\Livewire\Admin\Analysis\Competition;

use App\Models\Calculation;
use Livewire\Component;
use App\Models\Competition;
use App\Models\Stat;
use App\Traits\Livewire\CheckGuard;
use App\Traits\SubmissionTrait;
use App\Traits\ZoneTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Overall extends Component
{
    use LivewireAlert, CheckGuard, ZoneTrait, SubmissionTrait;

    protected $guard = 'admin';

    public Competition $competition;
    public Calculation $calculation;
    public Stat $stat;
    public $zones;

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
        $this->competition->calculateCarbonEmissionStats();
        $this->competition->calculateSubmissionStats();

        $this->fill([
            'calculation' => $this->competition->calculation,
            'stat' => $this->competition->stat,
        ]);

        $this->dispatchBrowserEvent('initChartAndMap', [
            'months' => $this->competition->getMonthNames(),
            'total_carbon_emission_each_month' => $this->calculation->total_carbon_emission_each_month->values(),
            'total_submission_each_month' => $this->stat->total_submission_each_month->values(),
            'zones' => $this->zones,
            'total_carbon_emission_each_zone' => $this->calculation->total_carbon_emission_each_zone,
            'total_submission_each_zone' => $this->stat->total_submission_each_zone,
        ]);

        $this->isLoading = false;
    }

    public function render()
    {
        $this->submission_categories = $this->getSubmissionCategories();

        return view('livewire.admin.analysis.competition.overall');
    }
}
