<?php

namespace App\Http\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Calculation;
use App\Models\Competition;
use App\Traits\CategoryTrait;
use App\Traits\CompetitionTrait;
use App\Traits\Livewire\CheckGuard;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TotalCollection extends Component
{
    use LivewireAlert, CheckGuard, CategoryTrait, CompetitionTrait;

    protected $guard = 'admin';
    public $categories;
    public Competition $competition;
    public Calculation $calculation;

    protected function getListeners()
    {
        return [

        ];
    }

    public function mount()
    {
        $this->categories = $this->getCategories()->take(4);
        $this->competition = $this->getCurrentCompetition();

        $this->competition->calculateCarbonEmissionStats();
        $this->calculation = $this->competition->calculation;
    }

    public function render()
    {
        return view('livewire.admin.dashboard.total-collection');
    }
}
