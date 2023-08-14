<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Zone as ZoneModel;
use App\Traits\Livewire\CheckGuard;
use App\Traits\ZoneTrait;
use Axiom\Rules\LocationCoordinates;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Zone extends Component
{
    use LivewireAlert, CheckGuard, ZoneTrait;

    protected $guard = 'admin';

    public $zones;
    public ZoneModel $zone;

    public $zone_id;

    public Collection $coordinates;

    public $isLoading = true;

    protected function getListeners()
    {
        return [
            'closeModal' => 'close',
            'delete'
        ];
    }

    public function addCoordinate()
    {
        $this->coordinates->push(['']);
    }

    public function removeCoordinate($index)
    {
        if ($this->coordinates->count() <= 3)
            $this->alert('error', __("3 Coordinates is needed for this Zone"), [
                'position' => 'top'
            ]);
        else {
            $this->coordinates->pull($index);
            $this->coordinates = $this->coordinates->values();
        }
    }

    protected function rules()
    {
        return [
            'zone.name' => 'required|string|unique:zones,name',
            'zone.number' => 'required|numeric|unique:zones,number',
            'coordinates' => 'required|array|min:3',
            'coordinates.*' => [
                'required',
                'string',
                'distinct',
                new LocationCoordinates
            ],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($zones)
    {
        $this->fill([
            'zones' => $zones,
            'zone' => new ZoneModel,
            'coordinates' => collect([
                '',
                '',
                '',
            ])
        ]);
    }

    public function getZoneProperty()
    {
        return $this->getZone($this->zone_id);
    }

    public function open($zone_id)
    {
        $this->zone_id = $zone_id;
        $this->zone = $this->getZoneProperty();
        $this->coordinates = $this->zone->transformToInput();

        $this->isLoading = false;
    }

    public function close()
    {
        $this->reset([
            'zone_id',
            'isLoading'
        ]);

        $this->fill([
            'zone' => new ZoneModel,
            'coordinates' => collect([
                '',
                '',
                '',
            ])
        ]);
    }

    public function create()
    {
        $this->zone->setCoordinates($this->coordinates);
        $this->zone->save();

        return redirect(route('admin.zone.list'))->with('success', __("alerts.zone_create", ['name' => $this->zone->name, 'number' => $this->zone->number]));
    }

    public function update()
    {
        $this->zone->setCoordinates($this->coordinates);
        $this->zone->save();

        return redirect(route('admin.zone.list'))->with('success', __("alerts.zone_update", ['name' => $this->zone->name, 'number' => $this->zone->number]));
    }

    public function askDelete($zone_id)
    {
        $zone = $this->getZone($zone_id);

        $this->alert('warning',  __('Warning'), [
            'inputAttributes' => [
                'zone_id' => $zone_id
            ],
            'position' => 'center',
            'timer' => null,
            'toast' => true,
            'text' => __("alerts.zone_delete_confirmation", ['name' => $zone->name, 'number' => $zone->number]),
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'cancelButtonText' => __('Cancel'),
            'confirmButtonText' => __('Confirm'),
            'onConfirmed' => 'delete',
            'onDismissed' => '',
        ]);
    }

    public function delete($response)
    {
        $zone = $this->getZone($response['data']['inputAttributes']['zone_id']);

        $zone->delete();

        redirect(route('admin.zone.list'))->with('success', __("alerts.question_delete"));
    }

    public function render()
    {
        return view('livewire.admin.zone');
    }
}
