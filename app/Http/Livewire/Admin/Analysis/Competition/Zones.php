<?php

namespace App\Http\Livewire\Admin\Analysis\Competition;

use App\Models\Stat;
use App\Models\Zone;
use Livewire\Component;
use App\Traits\ZoneTrait;
use App\Models\Calculation;
use App\Models\Competition;
use App\Traits\CalculationTrait;
use App\Traits\Livewire\CheckGuard;
use App\Traits\StatTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Zones extends Component
{
    use LivewireAlert, CheckGuard, ZoneTrait, CalculationTrait, StatTrait;
    protected $guard = 'admin';

    public Competition $competition;
    public Zone $zone;
    public Calculation $calculation;
    public Stat $stat;

    public $zones;
    public $submission_categories;

    public $competition_id;
    public $zone_id;

    public $average_carbon_emission_by_month;
    public $average_submission_by_month;

    public $isLoading = false;

    protected function getListeners()
    {
        return [
            'analysis',
            'calculate'
        ];
    }

    protected function rules()
    {
        return [
            'zone_id' => 'required|numeric|exists:zones,id'
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
            'zones' => $this->getZones(),
            'submission_categories' => $this->getSubmissionCategories(),
            'zone_id' => $this->getZones()->first()->id
        ]);

        $this->fill([
            'zone' => $this->getZoneProperty(),
            'calculation' => $this->getCalculationProperty(),
            'stat' => $this->getStatProperty(),
        ]);
    }

    public function getZoneProperty()
    {
        return $this->getZone($this->zone_id);
    }

    public function getCalculationProperty()
    {
        return $this->getCalculationByClassAndID($this->competition->id, Competition::class);
    }

    public function getStatProperty()
    {
        return $this->getStatByClassAndID($this->competition->id, Competition::class);
    }

    public function calculate()
    {
        [
            $total_carbon_emission_each_month,
            $total_submission_each_month,
            $average_carbon_emission_by_month,
            $average_submission_by_month
        ] = $this->zone->calculateStatsByCompetition($this->competition_id);

        $this->fill([
            'average_carbon_emission_by_month' => $average_carbon_emission_by_month,
            'average_submission_by_month' => $average_submission_by_month,
        ]);

        $this->dispatchBrowserEvent('initChart', [
            'months' => $this->competition->getMonthNames(),
            'total_carbon_emission_each_month' => collect($total_carbon_emission_each_month)->values(),
            'total_submission_each_month' => collect($total_submission_each_month)->values(),
        ]);

    }

    public function analysis()
    {
        $this->isLoading = true;

        $this->zone = $this->getZoneProperty();
        $this->calculate();

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.admin.analysis.competition.zones');
    }
}
