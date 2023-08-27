<?php

namespace App\Http\Livewire\Admin\Analysis\Competition;

use App\Models\Month;
use Livewire\Component;
use App\Models\Competition;
use App\Traits\Livewire\CheckGuard;
use App\Traits\MonthTrait;
use App\Traits\SubmissionTrait;
use App\Traits\ZoneTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Monthly extends Component
{
    use LivewireAlert, CheckGuard, MonthTrait, SubmissionTrait, ZoneTrait;
    protected $guard = 'admin';

    public Competition $competition;
    public Month $month;

    public $carbon_emission_stats;
    public $submission_stats;
    public $submission_categories;

    public $competition_id;
    public $month_id;

    public $isLoading = false;

    protected function getListeners()
    {
        return [
            'getAnalysis',
            'initMap'
        ];
    }

    protected function rules()
    {
        return [
            'month_id' => 'required|numeric|exists:months,id'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($competition)
    {
        $this->fill([
            'competition' => $competition,
            'competition_id' => $competition->id,
        ]);

        $this->month = $this->competition->months->get(0);
        $this->month_id = $this->month->id;

        $this->carbon_emission_stats = $this->month->getCarbonEmissionStats();
        $this->submission_stats = $this->month->getSubmissionStats();
    }

    public function getMonthProperty()
    {
        return $this->getMonth($this->month_id);
    }

    public function getAnalysis()
    {
        $this->isLoading = true;

        $this->month = $this->getMonthProperty();

        $this->carbon_emission_stats = $this->month->getCarbonEmissionStats();
        $this->submission_stats = $this->month->getSubmissionStats();

        [$total_carbon_emission_by_zone] = $this->carbon_emission_stats;
        [$total_submission_by_zone] = $this->submission_stats;

        $this->dispatchBrowserEvent('initMap', [
            'zones' => $this->getZones(),
            'total_carbon_emission_by_zone' => $total_carbon_emission_by_zone,
            'total_submission_by_zone' => $total_submission_by_zone,
        ]);

        $this->isLoading = false;
    }

    public function render()
    {
        $this->submission_categories = $this->getSubmissionCategories();

        return view('livewire.admin.analysis.competition.monthly');
    }
}
