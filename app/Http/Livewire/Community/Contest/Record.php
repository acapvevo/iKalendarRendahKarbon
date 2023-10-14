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
use App\Traits\Livewire\CheckGuard;
use App\Traits\SubmissionTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Record extends Component
{
    use LivewireAlert, CheckGuard, SubmissionTrait;

    protected $guard = 'community';
    protected $rules;

    public $community_id;
    public $competition_id;
    public $month_id;

    protected $category;
    public $category_name;
    public $category_description;
    public $category_symbol;
    public $category_code;
    public $category_class;

    public Submission $submission;
    public Month $month;
    public Bill $bill;
    public Electric $electric;
    public Water $water;
    public Recycle $recycle;
    public UsedOil $used_oil;

    public $tab_state = 1;

    protected function getListeners()
    {
        return [
            'closeModal' => 'close',
        ];
    }

    public function rules()
    {
        switch ($this->category_name) {
            case 'electric':
            case 'water':
                $rules = [
                    $this->category_name . '.usage' => 'required|numeric',
                    $this->category_name . '.charge' => 'required|numeric',
                ];
                break;

            case 'recycle':
            case 'used_oil':
                $rules = [
                    $this->category_name . '.weight' => 'required|numeric',
                    $this->category_name . '.value' => 'required|numeric',
                ];
                break;

            default:
                $rules = [];
        }

        return $rules;
    }

    public function updated($propertyName)
    {

        $this->validateOnly($propertyName);
    }

    public function mount($submission, $category)
    {
        $this->competition_id = $submission->competition_id;
        $this->community_id = $submission->community_id;

        $this->submission = $this->getSubmissionProperty();

        $this->fill([
            'bill' => new Bill,
            'month' => new Month,
        ]);

        $this->category = $this->getSubmissionCategory($category);

        $this->fill([
            'category_name' => $this->category->name,
            'category_description' => $this->category->description,
            'category_symbol' => $this->category->symbol,
            'category_code' => $this->category->code,
            'category_class' => $this->category->class,
        ]);

        $this->{$this->category_name} = resolve($this->category->class);
    }

    public function getSubmissionProperty()
    {
        return $this->getSubmissionByCompetitionIDAndCommunityID($this->competition_id, $this->community_id);
    }

    public function getBillProperty()
    {
        return $this->submission->getBillByMonthID($this->month_id);
    }

    public function getMonthProperty()
    {
        return $this->bill->month;
    }

    public function getCategoryProperty()
    {
        return $this->getSubmissionCategoryClass($this->category_code, $this->bill);
    }

    public function open($month_id)
    {
        $this->month_id = $month_id;
        $this->bill = $this->getBillProperty();
        $this->month = $this->getMonthProperty();
        $this->{$this->category_name} = $this->getCategoryProperty();
    }

    public function close()
    {
        $this->fill([
            'bill' => new Bill,
            'month' => new Month,
            'tab_state' => 1,
            $this->category_name => resolve($this->category_class)
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

    public function update()
    {
        $this->validate();

        $this->submission = $this->getSubmissionProperty();
        if (!$this->submission->id)
            $this->submission->save();

        if (!$this->bill->submission_id || !$this->bill->month_id) {
            $this->bill->submission_id = $this->submission->id;
            $this->bill->month_id = $this->month_id;
        }
        if (!$this->bill->id)
            $this->bill->save();

        $this->{$this->category_name}->calculateCarbonEmission();
        $this->{$this->category_name}->parent_id = $this->bill->id;
        $this->{$this->category_name}->parent_type = Bill::class;
        $this->{$this->category_name}->save();

        $this->bill->calculateStats();
        $this->bill->save();

        $this->submission->calculateStats();
        $this->submission->save();

        redirect(route('community.contest.submission.list', ['competition_id' => $this->competition_id, 'category' => $this->category_code]))->with('success', __('alerts.record_update', ['month' => $this->month->getName(), 'category' => __($this->category_description)]));
    }

    public function render()
    {
        $this->submission = $this->getSubmissionProperty();

        return view('livewire.community.contest.record');
    }
}
