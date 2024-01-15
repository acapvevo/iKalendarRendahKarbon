<?php

namespace App\Http\Livewire\Admin\Analysis\Activity;

use App\Traits\ActivityTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Traits\Livewire\CheckGuard;
use Livewire\Component;

class Overall extends Component
{
    use LivewireAlert, CheckGuard, ActivityTrait;

    protected $guard = 'admin';

    public $year;
    public $analysis;
    public $activity_categories;

    public $isLoading = true;

    protected function getListeners()
    {
        return [
            'analysis'
        ];
    }

    public function mount($year)
    {
        $this->year = $year;
        $this->activity_categories = $this->getActivityCategories();
    }

    public function analysis()
    {
        $this->isLoading = true;

        $this->analysis = $this->getAnalysisByYear($this->year);

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.admin.analysis.activity.overall');
    }
}
