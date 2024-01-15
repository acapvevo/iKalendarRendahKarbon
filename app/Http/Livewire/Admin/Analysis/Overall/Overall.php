<?php

namespace App\Http\Livewire\Admin\Analysis\Overall;

use App\Models\Competition;
use App\Traits\ActivityTrait;
use App\Traits\CalculationTrait;
use App\Traits\CategoryTrait;
use App\Traits\CompetitionTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Traits\Livewire\CheckGuard;
use App\Traits\Services\eLestariTrait;
use Livewire\Component;

class Overall extends Component
{
    use LivewireAlert, CheckGuard, CompetitionTrait, ActivityTrait, CategoryTrait, CalculationTrait, eLestariTrait;

    protected $guard = 'admin';

    public Competition $competition;
    public $categories;

    public $total_carbon_emission;
    public $total_carbon_emission_by_type;

    public $isLoading = true;

    protected function getListeners()
    {
        return [
            'analysis'
        ];
    }

    public function mount($competition)
    {
        $this->fill([
            'competition' => $competition,
            'categories' => $this->getCategories()
        ]);
    }

    public function getCalculationProperty()
    {
        return $this->getCalculationByClassAndID($this->competition->id, Competition::class);
    }

    public function analysis()
    {
        $this->isLoading = true;

        $activities_analysis = $this->getAnalysisByYear($this->competition->year);

        $this->competition->calculateCarbonEmissionStats();
        $competition_analysis = $this->getCalculationProperty();

        $this->total_carbon_emission = $competition_analysis->total_carbon_emission + $activities_analysis['total_carbon_emission'];
        foreach ($this->categories as $category) {
            $this->total_carbon_emission_by_type[$category['name']] = ($competition_analysis->total_carbon_emission_each_type[$category['name']] ?? 0) + ($activities_analysis['total_carbon_emission_each_category'][$category['name']] ?? 0);
        }

        $elestari_data = $this->getAuditTenagaData($this->competition->year, 1, 12);
        
        $this->total_carbon_emission += $elestari_data['jumlahPenguranganPembebasanCO2Keseluruhan'];
        $this->total_carbon_emission_by_type['electric'] = $elestari_data['jumlahPenguranganPembebasanCO2']['Elektrik'];
        $this->total_carbon_emission_by_type['water'] = $elestari_data['jumlahPenguranganPembebasanCO2']['Air'];
        $this->total_carbon_emission_by_type['recycle'] = $elestari_data['jumlahPenguranganPembebasanCO2']['KitarSemula'];
        $this->total_carbon_emission_by_type['used_oil'] = $elestari_data['jumlahPenguranganPembebasanCO2']['Minyak'];

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.admin.analysis.overall.overall');
    }
}
