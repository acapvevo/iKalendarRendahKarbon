<?php

namespace App\Http\Livewire\Resident\User;

use Livewire\Component;
use App\Models\Resident;
use Illuminate\Validation\Rule;
use App\Traits\Livewire\CheckGuard;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Profile extends Component
{
    use CheckGuard;

    protected $guard = 'resident';

    public Resident $user;

    public function mount($user)
    {
        $this->user = $user;
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
            ]
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

        redirect(route('resident.user.profile.view'))->with('success', __('alerts.user_update'));
    }

    public function render()
    {
        return view('livewire.resident.user.profile');
    }
}
