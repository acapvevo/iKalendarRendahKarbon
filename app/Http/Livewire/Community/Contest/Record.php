<?php

namespace App\Http\Livewire\Community\Contest;

use App\Models\Bill;
use App\Models\Month;
use App\Models\Water;
use App\Models\Recycle;
use App\Models\UsedOil;
use Livewire\Component;
use App\Models\Electric;
use App\Models\Submission;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Record extends Component
{
    use LivewireAlert, WithFileUploads;

    public $community_id;
    public $competition_id;
    public $submission_id;
    public $month_id;

    public Submission $submission;
    public Month $month;
    public Bill $bill;

    public Electric $electric;
    public Water $water;
    public Recycle $recycle;
    public UsedOil $used_oil;

    public $electric_evidence;
    public $water_evidence;
    public $recycle_evidence;
    public $used_oil_evidence;

    public $electric_evidence_label;
    public $water_evidence_label;
    public $recycle_evidence_label;
    public $used_oil_evidence_label;

    public $tab_state = 1;
    private $fileInputPlaceholder;

    protected function listener()
    {
        return [
            'changePlaceholder',
            'closeModal' => 'close',
        ];
    }

    protected function rules()
    {
        return [
            'electric.usage' => 'required|numeric',
            'electric.charge' => 'required|numeric',
            'electric_evidence' => [
                'nullable',
                'file',
                'mimes:jpg,png,pdf',
                'max:4096',
                Rule::requiredIf(function () {
                    return !$this->electric->evidence;
                })
            ],
            'water.usage' => 'required|numeric',
            'water.charge' => 'required|numeric',
            'water_evidence' =>  [
                'nullable',
                'file',
                'mimes:jpg,png,pdf',
                'max:4096',
                Rule::requiredIf(function () {
                    return !$this->water->evidence;
                })
            ],
            'recycle.weight' => 'required|numeric',
            'recycle.value' => 'required|numeric',
            'recycle_evidence' =>  [
                'nullable',
                'file',
                'mimes:jpg,png,pdf',
                'max:4096',
                Rule::requiredIf(function () {
                    return !$this->recycle->evidence;
                })
            ],
            'used_oil.weight' => 'required|numeric',
            'used_oil.value' => 'required|numeric',
            'used_oil_evidence' =>  [
                'nullable',
                'file',
                'mimes:jpg,png,pdf',
                'max:4096',
                Rule::requiredIf(function () {
                    return !$this->used_oil->evidence;
                })
            ],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function boot()
    {
        $this->fileInputPlaceholder = [
            'electric' =>  __("Upload Your Electric Bill for") . ' ',
            'water' =>  __("Upload Your Water Bill for") . ' ',
            'recycle' =>  __("Upload Your Recycle Sell Receipt for") . ' ',
            'used_oil' =>  __("Upload Your Used Oil Sell Receipt for") . ' ',
        ];
    }

    public function mount($submission)
    {
        $this->submission_id = $submission->id;
        $this->competition_id = $submission->competition_id;
        $this->community_id = $submission->community_id;

        $this->submission = $this->getSubmissionProperty();

        $this->fill([
            'bill' => new Bill,
            'month' => new Month,
            'electric' => new Electric,
            'water' => new Water,
            'recycle' => new Recycle,
            'used_oil' => new UsedOil,
        ]);
    }

    public function getSubmissionProperty()
    {
        return $this->submission_id ? Submission::find($this->submission_id) : new Submission([
            'competition_id' => $this->competition_id,
            'community_id' => $this->community_id,
        ]);
    }

    public function getBillProperty()
    {
        return $this->submission->getBillByMonthID($this->month_id);
    }

    public function getElectricProperty()
    {
        return $this->bill->electric ?? new Electric([
            'bill_id' => $this->bill->id
        ]);
    }

    public function getWaterProperty()
    {
        return $this->bill->water ?? new Water([
            'bill_id' => $this->bill->id
        ]);
    }

    public function getRecycleProperty()
    {
        return $this->bill->recycle ?? new Recycle([
            'bill_id' => $this->bill->id
        ]);
    }

    public function getUsedOilProperty()
    {
        return $this->bill->used_oil ?? new UsedOil([
            'bill_id' => $this->bill->id
        ]);
    }

    public function getMonthProperty()
    {
        return $this->bill->month;
    }

    public function open($month_id)
    {
        $this->month_id = $month_id;
        $this->bill = $this->getBillProperty();
        $this->month = $this->getMonthProperty();

        $this->fill([
            'electric' => $this->getElectricProperty(),
            'water' => $this->getWaterProperty(),
            'recycle' => $this->getRecycleProperty(),
            'used_oil' => $this->getUsedOilProperty(),
        ]);

        $this->reset([
            'electric_evidence',
            'water_evidence',
            'recycle_evidence',
            'used_oil_evidence',
        ]);

        foreach ($this->fileInputPlaceholder as $type => $placeholder) {
            $this->{$type . '_evidence_label'} = $placeholder . $this->month->getName();
        }
    }

    public function close()
    {
        $this->fill([
            'bill' => new Bill,
            'month' => new Month,
            'electric' => new Electric,
            'water' => new Water,
            'recycle' => new Recycle,
            'used_oil' => new UsedOil,
            'tab_state' => 1,
        ]);

        $this->reset([
            'electric_evidence',
            'water_evidence',
            'recycle_evidence',
            'used_oil_evidence',
        ]);

        $this->emit('changeTab', $this->tab_state);

        $this->resetErrorBag();
    }

    public function nextTab()
    {
        $this->tab_state++;

        $this->emit('changeTab', $this->tab_state);
    }

    public function previousTab()
    {
        $this->tab_state--;

        $this->emit('changeTab', $this->tab_state);
    }

    public function setTab($tab_state)
    {
        $this->tab_state = $tab_state;
    }

    public function changePlaceholder()
    {
        foreach ($this->fileInputPlaceholder as $type => $placeholder) {
            $file = $this->{$type . '_evidence'};
            $this->{$type . '_evidence_label'} = $file ? $file->getClientOriginalName()  : $placeholder . ($this->month ? $this->month->getName() : '');
        }
    }

    public function update()
    {
        $this->validate();

        $this->submission = $this->getSubmissionProperty();
        if (!$this->submission->id)
            $this->submission->save();

        if (!$this->bill->submission_id || !$this->bill->month_id){
            $this->bill->submission_id = $this->submission->id;
            $this->bill->month_id = $this->month_id;
        }
        if (!$this->bill->id)
            $this->bill->save();

        foreach ($this->fileInputPlaceholder as $type => $placeholderText) {
            if (!$this->{$type}->bill_id)
                $this->{$type}->bill_id = $this->bill->id;

            if ($this->{$type . '_evidence'}) {
                $file = $this->{$type . '_evidence'};
                $this->{$type}->evidence = "evidence_{$type}_" . $this->{$type}->bill->month->getUploadName() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('evidences/' . $this->submission->competition->year . '/' . $this->community_id, $this->{$type}->evidence);
            }

            $this->{$type}->calculateCarbonEmission();
            $this->{$type}->save();
        }

        $this->submission->calculateTotalCarbonEmission();

        redirect(route('community.contest.submission.list', ['competition_id' => $this->competition_id]))->with('success', __('alerts.record_update', ['month' => $this->month->getName()]));
    }

    public function render()
    {
        $this->submission = $this->getSubmissionProperty();
        $this->changePlaceholder();

        return view('livewire.community.contest.record');
    }
}
