<?php

namespace App\Http\Livewire\Admin\Contest;

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

    protected $guard = 'admin';

    public $submission_id;
    public $bill_id;
    public $month_id;

    public Submission $submission;
    public Bill $bill;
    public Month $month;
    public Electric $electric;
    public Water $water;
    public Recycle $recycle;
    public UsedOil $used_oil;

    public $submission_categories;

    protected function getListeners()
    {
        return [
            'closeModal' => 'close'
        ];
    }

    public function mount($submission)
    {
        $this->submission_id = $submission->id;

        $this->fill([
            'bill' => new Bill,
            'month' => new Month,
            'electric' => new Electric,
            'water' => new Water,
            'recycle' => new Recycle,
            'used_oil' => new UsedOil,
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

    public function getSubmissionProperty()
    {
        return $this->getSubmission($this->submission_id);
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
        ]);
    }

    public function render()
    {
        $this->submission = $this->getSubmissionProperty();
        $this->submission_categories = $this->getSubmissionCategories();

        return view('livewire.admin.contest.record');
    }
}
