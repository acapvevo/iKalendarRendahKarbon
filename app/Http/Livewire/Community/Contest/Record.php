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
    protected $rules;

    public $community_id;
    public $competition_id;
    public $submission_id;
    public $month_id;

    public $category;
    public $categoryName;

    public Submission $submission;
    public Month $month;
    public Bill $bill;
    public Electric $electric;
    public Water $water;
    public Recycle $recycle;
    public UsedOil $used_oil;

    public $evidence;
    public $evidence_label;

    public $tab_state = 1;
    public $fileInputPlaceholder;

    protected function getListeners()
    {
        return [
            'changePlaceholder',
            'closeModal' => 'close',
        ];
    }

    public function rules()
    {
        return [
            'electric.usage' => 'required|numeric',
            'electric.charge' => 'required|numeric',
            'water.usage' => 'required|numeric',
            'water.charge' => 'required|numeric',
            'recycle.weight' => 'required|numeric',
            'recycle.value' => 'required|numeric',
            'used_oil.weight' => 'required|numeric',
            'used_oil.value' => 'required|numeric',
            'evidence' =>  [
                'nullable',
                'file',
                'mimes:jpg,png,pdf',
                'max:4096'
            ],
        ];
    }

    private function setRules()
    {
        switch ($this->category) {
            case 'electric':
                $rules = [
                    'electric.usage' => 'required|numeric',
                    'electric.charge' => 'required|numeric',
                ];
                $requiredIf =
                    Rule::requiredIf(function () {
                        return !$this->electric->evidence;
                    });
                break;

            case 'water':
                $rules = [
                    'water.usage' => 'required|numeric',
                    'water.charge' => 'required|numeric',
                ];
                $requiredIf =
                    Rule::requiredIf(function () {
                        return !$this->water->evidence;
                    });
                break;

            case 'recycle':
                $rules = [
                    'recycle.weight' => 'required|numeric',
                    'recycle.value' => 'required|numeric',
                ];
                $requiredIf =
                    Rule::requiredIf(function () {
                        return !$this->recycle->evidence;
                    });
                break;

            case 'used_oil':
                $rules = [
                    'used_oil.weight' => 'required|numeric',
                    'used_oil.value' => 'required|numeric',
                ];
                $requiredIf =
                    Rule::requiredIf(function () {
                        return !$this->used_oil->evidence;
                    });
                break;

            default:
                $rules = [];
                $requiredIf = null;
        }

        $rules = array_merge($rules, [
            'evidence' =>  [
                'nullable',
                'file',
                'mimes:jpg,png,pdf',
                'max:4096',
                $requiredIf
            ],
        ]);

        return $rules;
    }

    public function updated($propertyName)
    {

        $this->validateOnly($propertyName, $this->setRules());
    }

    public function mount($submission, $category)
    {
        $this->submission_id = $submission->id;
        $this->competition_id = $submission->competition_id;
        $this->community_id = $submission->community_id;

        $this->submission = $this->getSubmissionProperty();

        $this->fill([
            'category' => $category,
            'bill' => new Bill,
            'month' => new Month,
        ]);

        switch ($category) {
            case 'electric':
                $this->electric = new Electric;
                $this->categoryName = __('Electric');
                $this->fileInputPlaceholder = __("Upload Your Electric Bill for") . ' ';
                break;

            case 'water':
                $this->water = new Water;
                $this->categoryName = __('Water');
                $this->fileInputPlaceholder = __("Upload Your Water Bill for") . ' ';
                break;

            case 'recycle':
                $this->recycle = new Recycle;
                $this->categoryName = __('Recycle');
                $this->fileInputPlaceholder = __("Upload Your Recycle Sell Receipt for") . ' ';
                break;

            case 'used_oil':
                $this->used_oil = new UsedOil;
                $this->categoryName = __('Used Oil');
                $this->fileInputPlaceholder = __("Upload Your Used Oil Sell Receipt for") . ' ';
                break;

            default:
                break;
        }
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

    public function getMonthProperty()
    {
        return $this->bill->month;
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

    public function open($month_id)
    {
        $this->month_id = $month_id;
        $this->bill = $this->getBillProperty();
        $this->month = $this->getMonthProperty();

        switch ($this->category) {
            case 'electric':
                $this->electric = $this->getElectricProperty();
                break;

            case 'water':
                $this->water = $this->getWaterProperty();
                break;

            case 'recycle':
                $this->recycle = $this->getRecycleProperty();
                break;

            case 'used_oil':
                $this->used_oil = $this->getUsedOilProperty();
                break;

            default:
                break;
        }

        $this->evidence_label = $this->fileInputPlaceholder . $this->month->getName();
    }

    public function close()
    {
        $this->fill([
            'bill' => new Bill,
            'month' => new Month,
            'tab_state' => 1,
        ]);

        switch ($this->category) {
            case 'electric':
                $this->electric = new Electric;
                break;

            case 'water':
                $this->water = new Water;
                break;

            case 'recycle':
                $this->recycle = new Recycle;
                break;

            case 'used_oil':
                $this->used_oil = new UsedOil;
                break;

            default:
                break;
        }

        $this->reset('evidence');

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
        $file = $this->evidence;
        $this->evidence_label = $file ? $file->getClientOriginalName()  : $this->fileInputPlaceholder . ($this->month ? $this->month->getName() : '');
    }

    public function update()
    {
        $this->validate($this->setRules());

        $this->submission = $this->getSubmissionProperty();
        if (!$this->submission->id)
            $this->submission->save();

        if (!$this->bill->submission_id || !$this->bill->month_id) {
            $this->bill->submission_id = $this->submission->id;
            $this->bill->month_id = $this->month_id;
        }
        if (!$this->bill->id)
            $this->bill->save();


        if (!$this->{$this->category}->bill_id)
            $this->{$this->category}->bill_id = $this->bill->id;

        if ($this->evidence) {
            $file = $this->evidence;
            $this->{$this->category}->evidence = "evidence_{$this->category}_" . $this->{$this->category}->bill->month->getUploadName() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('evidences/' . $this->submission->competition->year . '/' . $this->community_id, $this->{$this->category}->evidence);
        }

        $this->{$this->category}->calculateCarbonEmission();
        $this->{$this->category}->save();

        $this->submission->calculateTotalCarbonEmission();

        redirect(route('community.contest.submission.list', ['competition_id' => $this->competition_id, 'category' => $this->category]))->with('success', __('alerts.record_update', ['month' => $this->month->getName(), 'category' => $this->categoryName]));
    }

    public function render()
    {
        $this->submission = $this->getSubmissionProperty();
        $this->changePlaceholder();

        return view('livewire.community.contest.record');
    }
}
