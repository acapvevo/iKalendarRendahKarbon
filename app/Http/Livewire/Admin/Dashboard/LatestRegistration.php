<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Traits\CommunityTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Traits\Livewire\CheckGuard;
use Livewire\Component;

class LatestRegistration extends Component
{
    use LivewireAlert, CheckGuard, CommunityTrait;

    protected $guard = 'admin';
    public $communities;

    protected function getListeners()
    {
        return [

        ];
    }

    public function mount()
    {
        $this->communities = $this->getCommunities()->sortBy('created_at', SORT_REGULAR, true)->take(5);
    }

    public function render()
    {
        return view('livewire.admin.dashboard.latest-registration');
    }
}
