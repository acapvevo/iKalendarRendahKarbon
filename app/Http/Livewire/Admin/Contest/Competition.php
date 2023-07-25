<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Competition as CompetitionModel;

class Competition extends Component
{
    use LivewireAlert;

    public $competitions;
    public CompetitionModel $competition;

    public function getListeners()
    {
        return [
            'delete'
        ];
    }

    protected function rules()
    {
        return [
            'competition.name' => 'required|string|max:2048',
            'competition.year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 3)
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($competitions)
    {
        $this->competitions = $competitions;
        $this->competition = new CompetitionModel;
    }

    public function open($id = null)
    {
        if ($id) {
            $this->competition = CompetitionModel::find($id);
        } else {
            $this->competition = new CompetitionModel;
        }
    }

    public function create()
    {
        $this->validate([
            'competition.year' => 'unique:competitions,year'
        ]);

        $this->competition->save();
        $this->competition->generateMonth();

        redirect(route('admin.contest.competition.list'))->with('success', __("alerts.competition_create", ['name' => $this->competition->name]));
    }

    public function update()
    {
        $this->validate([
            'competition.year' => [
                Rule::unique('competitions', 'year')->ignore($this->competition->id)
            ]
        ]);

        $this->competition->save();

        redirect(route('admin.contest.competition.list'))->with('success', __("alerts.competition_update", ['name' => $this->competition->name]));
    }

    public function close()
    {
        $this->competition = new CompetitionModel;
        $this->resetErrorBag();
    }

    public function askDelete($id)
    {
        $competition = CompetitionModel::find($id);

        $this->alert('warning', __('Warning'), [
            'inputAttributes' => [
                'id' => $id
            ],
            'position' => 'center',
            'timer' => null,
            'toast' => true,
            'text' => __("alerts.competition_delete_confirmation", ['name' => $competition->name]),
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
        $competition = CompetitionModel::find($response['data']['inputAttributes']['id']);

        $competition->delete();

        redirect(route('admin.contest.competition.list'))->with('success', __("alerts.competition_delete"));
    }

    public function render()
    {
        return view('livewire.admin.contest.competition');
    }
}
