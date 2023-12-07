<?php

namespace App\Http\Livewire\Community\User;

use Livewire\Component;
use App\Models\Community;
use App\Traits\FinanceTrait;
use Illuminate\Validation\Rule;
use App\Traits\Livewire\CheckGuard;
use App\Models\Finance as FinanceModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class Finance extends Component
{
    use WithFileUploads, CheckGuard, FinanceTrait;

    public Community $community;
    public FinanceModel $finance;

    public $bank_statement;
    public $bank_statement_label;

    public $bank_list;

    protected $guard = 'community';

    protected function getListeners()
    {
        return [
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

    public function mount($user)
    {
        $this->community = $user;

        $this->fill([
            'finance' => $this->getFinanceProperty(),
            'bank_statement_label' => __("Upload your Bank Statement"),
            'bank_list' => $this->getBankList()
        ]);
    }

    public function getFinanceProperty()
    {
        return $this->getFinanceByCommunityID($this->community->id);
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

        $this->saveFinance($this->community->id, $this->finance->getAttributes(), $this->bank_statement);

        return redirect(route('community.user.finance.view'))->with('success', __('alerts.finance_update'));
    }

    public function render()
    {
        $this->bank_list = $this->getBankList();
        $this->changePlaceholder();

        return view('livewire.community.user.finance');
    }
}
