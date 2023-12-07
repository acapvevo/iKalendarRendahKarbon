<?php

namespace App\Http\Livewire\Admin\Contest;

use Livewire\Component;
use App\Models\Submission;
use Illuminate\Validation\Rule;
use App\Traits\Livewire\CheckGuard;
use App\Models\Finance as FinanceModal;
use App\Traits\FinanceTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class Finance extends Component
{
    use WithFileUploads, CheckGuard, FinanceTrait;

    protected $guard = 'admin';

    public Submission $submission;
    public FinanceModal $finance;

    public $bank_statement;
    public $bank_statement_label;

    public $bank_list;

    protected function getListeners()
    {
        return [
            'openModal' => 'close',
            'closeModal' => 'close',
        ];
    }

    protected function rules()
    {
        return $this->getRules();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($submission)
    {
        $this->submission = $submission;

        $this->fill([
            'finance' => $this->getFinanceProperty(),
            'bank_statement_label' => __("Upload your Bank Statement"),
            'bank_list' => $this->getBankList()
        ]);
    }

    public function getFinanceProperty()
    {
        return $this->getFinanceByCommunityID($this->submission->community_id);
    }

    public function changePlaceholder()
    {
        $this->bank_statement_label = $this->bank_statement ? $this->bank_statement->getClientOriginalName()  : __("Upload your Bank Statement");
    }

    public function update()
    {
        $this->validate([
            'finance.account_number' => 'required',
            'finance.account_name' => 'required',
            'finance.bank' => 'required',
            'bank_statement' => [
                Rule::requiredIf(fn () => !isset($this->finance->bank_statement))
            ],
        ]);

        $this->saveFinance($this->submission->community_id, $this->finance->getAttributes(), $this->bank_statement);

        return redirect(route('admin.contest.winner.view', ['submission_id' => $this->submission->id]))->with('success', __('alerts.finance_update'));
    }

    public function render()
    {
        $this->changePlaceholder();
        $this->bank_list = $this->getBankList();

        return view('livewire.admin.contest.finance');
    }
}
