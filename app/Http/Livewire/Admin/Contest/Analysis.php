<?php

namespace App\Http\Livewire\Admin\Contest;

use App\Models\Bill;
use Livewire\Component;
use App\Models\Submission;
use App\Models\Calculation;
use App\Traits\BillTrait;
use App\Traits\CalculationTrait;
use App\Traits\Livewire\CheckGuard;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Analysis extends Component
{
    use CheckGuard, CalculationTrait, BillTrait;

    protected $guard = 'admin';

    public $isLoading = true;

    public Submission $submission;
    public Calculation $calculation;
    public Bill $current_bill;
    public Bill $last_bill;

    protected function getListeners()
    {
        return [
            'openModal' => 'open',
            'closeModal' => 'close',
        ];
    }

    public function mount($submission)
    {
        $this->submission = $submission;

        $this->fill([
            'calculation' => $this->initCalculation(),
            'last_bill' => $this->initBill(),
            'current_bill' => $this->initBill()
        ]);
    }

    public function getCalculationProperty()
    {
        return $this->getCalculationByClassAndID($this->submission->id, Submission::class);
    }

    public function calculate()
    {
        $this->submission->calculateStats();
        $this->calculation = $this->getCalculationProperty();

        $this->isLoading = false;
    }

    public function open($last_month_id, $current_month_id)
    {
        $this->current_bill = $this->getBillByMonthAndSubmission($current_month_id, $this->submission->id);
        $this->last_bill = $this->getBillByMonthAndSubmission($last_month_id, $this->submission->id);
    }

    public function close()
    {
        $this->fill([
            'last_bill' => $this->initBill(),
            'current_bill' => $this->initBill()
        ]);
    }

    public function render()
    {
        $this->dispatchBrowserEvent('initAsset');
        
        return view('livewire.admin.contest.analysis', [
            'calculate' => $this->isLoading
                ? $this->initCalculation()
                : $this->calculation,
        ]);
    }
}
