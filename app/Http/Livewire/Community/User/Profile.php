<?php

namespace App\Http\Livewire\Community\User;

use App\Models\Address;
use Livewire\Component;
use App\Models\Community;
use App\Models\Occupation;
use Illuminate\Validation\Rule;

class Profile extends Component
{
    public Community $user;
    public Address $address;
    public Occupation $occupation;

    public function mount($user)
    {
        $this->user = $user;
        $this->address = $user->address;
        $this->occupation = $user->occupation;
    }

    protected function rules()
    {
        return [
            'user.name' => 'nullable|string|max:255',
            'user.identification_number' => [
                'nullable',
                'string',
                'regex:/^\d{6}-\d{2}-\d{4}$/',
                Rule::unique('communities', 'identification_number')->ignore($this->user->id),
            ],
            'user.phone_number' => 'nullable|string',
            'user.email' => [
                'required',
                'email',
                'string',
                Rule::unique('communities', 'email')->ignore($this->user->id),
            ],
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

    public function update()
    {
        $this->validate();

        $this->user->save();
        $this->address->save();
        $this->occupation->save();

        redirect(route('community.user.profile.view'))->with('success', 'Your Profile has been updated successfully');
    }

    public function render()
    {
        return view('livewire.community.user.profile');
    }
}
