<?php

namespace App\Http\Livewire\Admin\Analysis\Competition;

use App\Models\Zone;
use Livewire\Component;
use App\Models\Competition;
use App\Traits\Livewire\CheckGuard;
use App\Traits\ZoneTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Zones extends Component
{
    use LivewireAlert, CheckGuard, ZoneTrait;
    protected $guard = 'admin';

    public Competition $competition;
    public Zone $zone;

    public $competition_id;
    public $zone_id;

    public $isLoading = false;

    protected function getListeners()
    {
        return [
            'change' => 'changeZone'
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
            'competition_id' => $competition->id
        ]);
    }

    public function getZoneProperty()
    {
        return $this->getZone($this->zone_id);
    }

    public function change($zone_id)
    {
    }

    public function render()
    {
        return view('livewire.admin.analysis.competition.zones');
    }
}
