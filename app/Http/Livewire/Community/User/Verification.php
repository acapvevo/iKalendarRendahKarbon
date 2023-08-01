<?php

namespace App\Http\Livewire\Community\User;

use App\Models\Community;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Verification extends Component
{
    use LivewireAlert, WithFileUploads;

    public Community $user;

    public $identification_card;
    public $identification_card_label;

    protected function rules()
    {
        return [
            'identification_card' => 'required|file|mimes:jpg,pdf,png|max:2048'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($user)
    {
        $this->fill([
            'user' => $user,
            'identification_card_label' => __("Upload Your Identification Card")
        ]);
    }

    public function changePlaceholder()
    {
        $file = $this->identification_card;
        $this->identification_card_label = $file ? $file->getClientOriginalName()  : __("Upload Your Identification Card");
    }

    public function save()
    {
        $this->validate();

        $file = $this->identification_card;
        $this->user->identification_card = "identification_card_" . $this->user->id . '.' . $file->getClientOriginalExtension();

        $file->storeAs('identification_card/community', $this->user->identification_card);

        $this->user->save();

        return redirect(route('community.user.profile.view'))->with('success', __('alerts.verification_processed'));
    }

    public function render()
    {
        $this->changePlaceholder();

        return view('livewire.community.user.verification');
    }
}
