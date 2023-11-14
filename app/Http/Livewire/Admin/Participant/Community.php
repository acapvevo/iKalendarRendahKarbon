<?php

namespace App\Http\Livewire\Admin\Participant;

use App\Models\Address;
use Livewire\Component;
use App\Models\Occupation;
use Livewire\WithFileUploads;
use App\Traits\CommunityTrait;
use Illuminate\Validation\Rule;
use App\Traits\Livewire\CheckGuard;
use Illuminate\Support\Facades\Hash;
use App\Models\Community as CommunityModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Community extends Component
{
    use LivewireAlert, WithFileUploads, CheckGuard, CommunityTrait;

    protected $guard = 'admin';

    public CommunityModel $community;
    public Address $address;
    public Occupation $occupation;

    public $community_batch_registration_file;
    public $input_file_label;

    public $community_id;
    public $resident_id;

    public $decision;
    public $community_selection;

    protected function getListeners()
    {
        return [
            'openModal' => 'open'
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
            'decision' => 'required|boolean',
            'community_batch_registration_file' => 'required|file|mimes:csv,xls,xlsx|max:2048'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($resident_id)
    {
        $this->fill([
            'resident_id' => $resident_id,
            'community' => new CommunityModel,
            'address' => new Address,
            'occupation' => new Occupation,
            'input_file_label' => __('Upload File for Batch Community Registration'),
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
            'input_file_label' => __("Upload File for Batch Community Registration"),
        ]);

        $this->reset('community_batch_registration_file');

        $this->resetErrorBag();
    }

    public function changePlaceholder()
    {
        $file = $this->community_batch_registration_file;
        $this->input_file_label = $file ? $file->getClientOriginalName()  : __("Upload File for Batch Community Registration");
    }

    public function create()
    {
        $this->validate([
            'community.username' => 'required|string|max:255|unique:communities,username',
            'community.email' => 'required|string|email|max:255|unique:communities,email',
        ]);

        $this->community = $this->createCommunity([
            'resident_id' => $this->resident_id,
            'username' => $this->community->username,
            'email' => $this->community->email,
            'password' => Hash::make($this->community->username),
        ], [
            'state' => 'JOHOR',
            'country' => 'MALAYSIA',
        ], []);

        return redirect(route('admin.participant.community.list', ['resident_id' => $this->resident_id]))->with('success', __('alerts.community_create', ['name' => $this->community->username]));
    }

    public function batchCreate()
    {
        $this->validate([
            'community_batch_registration_file' => 'required|file|mimes:csv,xls,xlsx|max:2048'
        ]);

        $this->batchCreateCommunity($this->community_batch_registration_file, $this->resident_id);

        return redirect(route('admin.participant.community.list', ['resident_id' => $this->resident_id]))->with('success', __('alerts.community_batch_create'));
    }

    public function add()
    {
        $this->validate([
            'community_selection' => 'required'
        ]);

        foreach ($this->community_selection as $community_id) {
            $community = $this->getCommunity($community_id);

            $community->resident_id = $this->resident_id;

            $community->save();
        }

        return redirect(route('admin.participant.community.list', ['resident_id' => $this->resident_id]))->with('success', __("alerts.comunity_add"));
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

        return redirect(route('admin.participant.community.list', ['resident_id' => $this->resident_id]))->with('success', __('alerts.community_update', ['name' => $this->community->name ?? $this->community->username]));
    }

    public function verify()
    {
        $this->validate([
            'decision' => 'required|boolean'
        ]);

        if ($this->decision) {
            $this->community->isVerified = true;
        } else {
            $this->community->deleteIdentificationCard();
        }

        $this->community->save();

        return redirect(route('admin.participant.community.list'))->with('success', __('alerts.verification_complete', ['name' => $this->community->name ?? $this->community->username]));
    }

    public function render()
    {
        $this->changePlaceholder();

        return view('livewire.admin.participant.community');
    }
}
