<?php

namespace App\Http\Livewire\Admin\Participant;

use Livewire\Component;
use App\Traits\ResidentTrait;
use Axiom\Rules\TelephoneNumber;
use App\Traits\Livewire\CheckGuard;
use Illuminate\Support\Facades\Hash;
use App\Models\Resident as ResidentModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Resident extends Component
{
    use LivewireAlert, CheckGuard, ResidentTrait;

    protected $guard = 'admin';

    public ResidentModel $resident;

    public $resident_id;

    protected function getListeners()
    {
        return [
            'viewCommunity' => 'community',
            'openModal' => 'open',
            'closeModal' => 'close'
        ];
    }

    protected function rules()
    {
        return [
            'resident.name' => 'string|max:255',
            'resident.username' => 'string|max:255',
            'resident.email' => 'string|email|max:255',
            'resident.phone_number' => [
                'string',
                'max:255'
            ],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->fill([
            'resident' => $this->initResident()
        ]);
    }

    public function getResidentProperty()
    {
        return $this->resident_id ? $this->getResident($this->resident_id) : $this->initResident();
    }

    public function open($resident_id = null)
    {
        $this->resident_id = $resident_id;
        $this->resident = $this->getResidentProperty();

        $this->dispatchBrowserEvent('initTelInput');
    }

    public function close()
    {
        $this->fill([
            'resident_id' => null,
            'resident' => $this->initResident()
        ]);
    }

    public function create()
    {
        $this->resident->password = Hash::make($this->resident->username);
        $this->createResident($this->resident->getAttributes());

        return redirect(route('admin.participant.resident.list'))->with('success', __('alerts.resident_create', ['name' => $this->resident->username]));
    }

    public function update()
    {
        $this->validate([
            'resident.name' => 'nullable|string|max:255',
            'resident.email' => 'required|string|email|max:255',
            'resident.phone_number' => [
                'nullable',
                'string',
                'max:255'
            ],
        ]);

        $this->resident->save();

        return redirect(route('admin.participant.resident.list'))->with('success', __('alerts.resident_update', ['name' => $this->resident->name ?? $this->resident->username]));
    }

    public function community($resident_id)
    {
        return redirect(route('admin.participant.community.list', [
            'resident_id' => $resident_id
        ]));
    }

    public function render()
    {
        return view('livewire.admin.participant.resident');
    }
}
