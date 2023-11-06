<?php

namespace App\Http\Livewire\Resident\Participant;

use App\Models\Address;
use Livewire\Component;
use App\Models\Occupation;
use App\Traits\ResidentTrait;
use App\Traits\CommunityTrait;
use Illuminate\Validation\Rule;
use App\Traits\Livewire\CheckGuard;
use Illuminate\Support\Facades\Hash;
use App\Models\Community as CommunityModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Community extends Component
{
    use LivewireAlert, CheckGuard, CommunityTrait, ResidentTrait;

    protected $guard = 'resident';

    public $community_id;

    public CommunityModel $community;
    public Address $address;
    public Occupation $occupation;

    public $community_selection;

    protected function getListeners()
    {
        return [
            'openModal' => 'open',
            'closeModal' => 'close'
        ];
    }

    protected function rules()
    {
        return [
            'community_selection' => 'array',
            'community_selection.*' => 'numeric|exists:communities,id',
            'community.username' => 'required|string|max:255|unique:communities,username',
            'community.email' => [
                'required',
                'email',
                'string',
                Rule::unique('communities', 'email')->ignore($this->community->id),
            ],
            'community.name' => 'nullable|string|max:255',
            'community.identification_number' => [
                'nullable',
                'string',
                'regex:/^\d{6}-\d{2}-\d{4}$/',
                Rule::unique('communities', 'identification_number')->ignore($this->community->id),
            ],
            'community.phone_number' => 'nullable|string',
            'address.category' => 'nullable|string|exists:address_category,code',
            'address.line_1' => 'nullable|string|max:255',
            'address.line_2' => 'nullable|string|max:255',
            'address.line_3' => 'nullable|string|max:255',
            'address.city' => 'nullable|string|max:255',
            'address.postcode' => 'nullable|string|max:255',
            'address.state' => 'nullable|string|in:JOHOR',
            'address.country' => 'nullable|string|in:MALAYSIA',
            'occupation.place' => 'required_with:occupation.position,occupation.sector|nullable|string|max:255',
            'occupation.position' => 'required_with:occupation.place,occupation.sector|nullable|string|max:255',
            'occupation.sector' => 'required_with:occupation.place,occupation.position|nullable|string|exists:occupation_sector_type,code',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->community = new CommunityModel;

        $this->fill([
            'community_id' => null,
            'community' => new CommunityModel,
            'address' => new Address,
            'occupation' => new Occupation,
            'community_selection' => null,
        ]);
    }

    public function getCommunityProperty()
    {
        return $this->getCommunity($this->community_id);
    }

    public function open($id)
    {
        $this->community_id = $id;
        $this->community = $this->getCommunityProperty();

        $this->fill([
            'address' => $this->community->address,
            'occupation' => $this->community->occupation,
        ]);
    }

    public function close()
    {
        $this->fill([
            'community_id' => null,
            'community' => new CommunityModel,
            'address' => new Address,
            'occupation' => new Occupation,
        ]);
    }

    public function add()
    {
        $this->validate([
            'community_selection' => 'required'
        ]);

        $resident = $this->getCurrentResident();

        foreach ($this->community_selection as $community_id) {
            $community = $this->getCommunity($community_id);

            $community->resident_id = $resident->id;

            $community->save();
        }

        return redirect(route('resident.participant.community.list'))->with('success', __("alerts.comunity_add"));
    }

    public function create()
    {
        $this->validate([
            'community.username' => 'required|string|max:255',
            'community.email' => 'required|string|email',
        ]);

        $this->community->password = Hash::make($this->community->username);
        $this->community->resident_id = $this->getCurrentResident()->id;

        $this->createCommunity($this->community->getAttributes(), [], []);

        return redirect(route('resident.participant.community.list'))->with('success', __("alerts.community_create"));
    }

    public function render()
    {
        return view('livewire.resident.participant.community');
    }
}
