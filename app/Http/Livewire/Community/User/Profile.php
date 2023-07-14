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
            'user.name' => 'required|string|max:255',
            'user.identification_number' => [
                'required',
                'string',
                'regex:/^\d{6}-\d{2}-\d{4}$/',
                Rule::unique('communities', 'identification_number')->ignore($this->user->id),
            ],
            'user.phone_number' => 'required|string',
            'user.email' => [
                'required',
                'email',
                'string',
                Rule::unique('communities', 'email')->ignore($this->user->id),
            ],
            'address.category' => 'required|string|exists:address_category,code',
            'address.line_1' => 'required|string|max:255',
            'address.line_2' => 'required|string|max:255',
            'address.line_3' => 'sometimes|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.postcode' => 'required|string|max:255',
            'address.state' => 'required|string|in:JOHOR',
            'address.country' => 'required|string|in:MALAYSIA',
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
