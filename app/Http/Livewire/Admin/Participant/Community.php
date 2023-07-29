<?php

namespace App\Http\Livewire\Admin\Participant;

use App\Models\Address;
use Livewire\Component;
use App\Models\Occupation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\Community as CommunityModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Community extends Component
{
    use LivewireAlert;

    public CommunityModel $community;
    public Address $address;
    public Occupation $occupation;

    public $community_id;

    protected function getListeners()
    {
        return [
            'openModal' => 'open'
        ];
    }

    protected function rules()
    {
        return [
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
            'occupation.sector' => 'required_with:occupation.place,occupation.position|nullable|string|exists:occupation_sector_type,code'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->fill([
            'community' => new CommunityModel,
            'address' => new Address,
            'occupation' => new Occupation,
        ]);
    }

    public function getCommunityProperty()
    {
        return $this->community_id ? CommunityModel::find($this->community_id) : new CommunityModel;
    }

    public function getAddressProperty()
    {
        return $this->community->address ?? new Address([
            'community_id' => $this->community_id,
            'state' => 'JOHOR',
            'country' => 'MALAYSIA',
        ]);
    }

    public function getOccupationProperty()
    {
        return $this->community->occupation ?? new Occupation([
            'community_id' => $this->community_id,
        ]);
    }

    public function open($community_id = null)
    {
        $this->community_id = $community_id;

        $this->community = $this->getCommunityProperty();
        $this->fill([
            'address' => $this->getAddressProperty(),
            'occupation' => $this->getOccupationProperty(),
        ]);
    }

    public function close()
    {
        $this->fill([
            'community' => new CommunityModel,
            'address' => new Address,
            'occupation' => new Occupation,
        ]);

        $this->resetErrorBag();
    }

    public function create()
    {
        $this->validate([
            'community.username' => 'required|string|max:255|unique:communities,username',
            'community.email' => 'required|string|email|max:255|unique:communities,email',
        ]);

        $this->community->password = Hash::make($this->community->username);
        $this->community->save();

        $this->community_id = $this->community->id;

        $this->fill([
            'address' => $this->getAddressProperty(),
            'occupation' => $this->getOccupationProperty(),
        ]);

        $this->address->save();
        $this->occupation->save();

        redirect(route('admin.participant.community.list'))->with('success', __('alerts.community_create', ['name' => $this->community->username]));
    }

    public function update()
    {
        $this->validate([
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
            'occupation.sector' => 'required_with:occupation.place,occupation.position|nullable|string|exists:occupation_sector_type,code'
        ]);

        $this->community->save();
        $this->address->save();
        $this->occupation->save();

        redirect(route('admin.participant.community.list'))->with('success', __('alerts.community_update', ['name' => $this->community->name ?? $this->community->username]));
    }

    public function render()
    {
        return view('livewire.admin.participant.community');
    }
}
