<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Traits\CategoryTrait;
use App\Traits\CompetitionTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Traits\Livewire\CheckGuard;
use Livewire\Component;

class TotalCollection extends Component
{
    use LivewireAlert, CheckGuard, CategoryTrait, CompetitionTrait;

    protected $guard = 'admin';
    public $categories;
    public $competition;
    public $calculation;

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
