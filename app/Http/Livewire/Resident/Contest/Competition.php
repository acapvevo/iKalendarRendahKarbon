<?php

namespace App\Http\Livewire\Resident\Contest;

use App\Models\Competition as CompetitionModel;
use App\Traits\CompetitionTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Traits\Livewire\CheckGuard;
use Livewire\Component;

class Competition extends Component
{
    use LivewireAlert, CheckGuard, CompetitionTrait;

    protected $guard = 'resident';

    public $competitions;

    public $competition_id;

    public CompetitionModel $competition;

    protected function getListeners()
    {
        return [
            'closeModal' => 'close'
        ];
    }

    protected function rules()
    {
        return [];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->competitions = $this->getCompetitions();
    }

    public function getCompetitionProperty()
    {
        return $this->getCompetition($this->competition_id);
    }

    public function open($competition_id)
    {
        $this->competition_id = $competition_id;
        $this->competition = $this->getCompetitionProperty();
    }

    public function close()
    {
        $this->fill([
            'competition_id' => null,
            'competition' =>  $this->initCompetition()
        ]);
    }

    public function view($competition_id)
    {
        return redirect(route('resident.contest.submission.list', ['competition_id' => $competition_id]));
    }

    public function render()
    {
        return view('livewire.resident.contest.competition');
    }
}
