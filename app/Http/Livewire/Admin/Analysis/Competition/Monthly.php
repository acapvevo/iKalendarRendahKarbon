<?php

namespace App\Http\Livewire\Admin\Analysis\Competition;

use App\Models\Stat;
use App\Models\Month;
use Livewire\Component;
use App\Traits\ZoneTrait;
use App\Traits\MonthTrait;
use App\Models\Calculation;
use App\Models\Competition;
use App\Traits\CalculationTrait;
use App\Traits\SubmissionTrait;
use App\Traits\Livewire\CheckGuard;
use App\Traits\StatTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Monthly extends Component
{
    use LivewireAlert, CheckGuard, MonthTrait, SubmissionTrait, ZoneTrait, CalculationTrait, StatTrait;
    protected $guard = 'admin';

    public Competition $competition;
    public $month;
    public Calculation $calculation;
    public Stat $stat;

    public $submission_categories;

    public $competition_id;
    public $month_id;

    public $isLoading = false;

    protected function getListeners()
    {
        return [
            'analysis',
            'map'
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

        $this->month = $this->competition->getMonthRange()->get(0);
        $this->month_id = $this->month->id;

        $this->calculate();
        $this->map();
    }

    public function getMonthProperty()
    {
        return $this->getMonth($this->month_id);
    }

    public function getCalculationProperty()
    {
        return $this->getCalculationByClassAndID($this->month->id, Month::class);
    }

    public function getStatProperty()
    {
        return $this->getStatByClassAndID($this->month->id, Month::class);
    }

    public function calculate()
    {
        $this->month->calculateCarbonEmissionStats();
        $this->month->calculateSubmissionStats();

        $this->fill([
            'calculation' => $this->getCalculationProperty(),
            'stat' => $this->getStatProperty(),
        ]);
    }

    public function map()
    {
        $this->dispatchBrowserEvent('initMap', [
            'zones' => $this->getZones(),
            'total_carbon_emission_each_zone' => $this->calculation->total_carbon_emission_each_zone,
            'total_submission_each_zone' => $this->stat->total_submission_each_zone,
        ]);
    }

    public function analysis()
    {
        $this->isLoading = true;

        $this->month = $this->getMonthProperty();

        $this->calculate();
        $this->map();

        $this->isLoading = false;
    }

    public function render()
    {
        $this->submission_categories = $this->getSubmissionCategories();

        return view('livewire.admin.analysis.competition.monthly');
    }
}
