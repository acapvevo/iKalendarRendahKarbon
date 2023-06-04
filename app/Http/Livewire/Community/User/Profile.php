<?php

namespace App\Http\Livewire\Community\User;

use App\Models\Address;
use Livewire\Component;
use App\Models\Community;
use Illuminate\Validation\Rule;

class Profile extends Component
{
    public Address $address;
    public Community $user;

    public function mount($user)
    {
        $this->user = $user;
        $this->address = $user->address;
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
            'address.line_1' => 'required|string|max:255',
            'address.line_2' => 'required|string|max:255',
            'address.line_3' => 'sometimes|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.postcode' => 'required|string|max:255',
            'address.state' => 'required|string|in:JOHOR',
            'address.country' => 'required|string|in:MALAYSIA',
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

        redirect(route('community.user.profile.view'))->with('success', 'Your Profile has been updated successfully');
    }
}
