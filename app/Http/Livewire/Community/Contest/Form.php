<?php

namespace App\Http\Livewire\Community\Contest;

use App\Models\Address;
use Livewire\Component;
use App\Models\Community;
use App\Traits\BillTrait;
use App\Models\Submission;
use App\Models\Competition;
use App\Traits\CategoryTrait;
use App\Traits\CommunityTrait;
use App\Traits\SubmissionTrait;
use Axiom\Rules\TelephoneNumber;
use Illuminate\Support\Facades\Hash;

class Form extends Component
{
    use CommunityTrait, SubmissionTrait, BillTrait, CategoryTrait;

    public $isRetrieved = false;
    public $isSaved = false;
    public $isLoading = false;
    public $current_tab = 'personal';
    public $records;

    public $category_symbol;
    public $category_code;

    public $competition_id;
    public $password;
    public $password_confirmation;

    public Competition $competition;
    public Community $community;
    public Address $address;
    public Submission $submission;

    private $tab_list = [
        'personal',
        'electric',
        'water',
        'recycle',
        'used_oil'
    ];

    protected function getListeners()
    {
        return [];
    }

    protected function rules()
    {

        switch ($this->current_tab) {
            case 'personal':
                return [
                    'community.email' => 'email',
                    'community.username' => 'string',
                    'password' => 'string|min:8',
                    'community.name' => 'string',
                    'community.identification_number' => 'string|regex:/^\d{6}-\d{2}-\d{4}$/',
                    'community.phone_number' => [
                        'string',
                        new TelephoneNumber
                    ],
                    'address.category' => 'string|exists:address_category,code',
                    'address.line_1' => 'string|max:255',
                    'address.line_2' => 'string|max:255',
                    'address.line_3' => 'string|max:255',
                    'address.city' => 'string|max:255',
                    'address.postcode' => 'string|max:255',
                    'address.state' => 'string|in:JOHOR',
                    'address.country' => 'string|in:MALAYSIA',
                ];
            case 'electric':
            case 'water':
                return [
                    'records.*.month_id' => 'numeric|exists:months,id',
                    'records.*.category' => 'string|exists:category,code',
                    'records.*.usage' => 'numeric|min:0|required_with:records.*.charge',
                    'records.*.charge' => 'numeric|min:0|required_with:records.*.usage',
                ];
            case 'recycle':
            case 'used_oil':
                return [
                    'records.*.month_id' => 'numeric|exists:months,id',
                    'records.*.category' => 'string|exists:category,code',
                    'records.*.value' => 'numeric|min:0|required_with:records.*.weight',
                    'records.*.weight' => 'numeric|min:0|required_with:records.*.value',
                ];
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($competition)
    {
        $this->competition_id = $competition->id;

        $this->fill([
            'community' => new Community,
            'address' => new Address([
                'state' => 'JOHOR',
                'country' => 'MALAYSIA'
            ]),
            'submission' => new Submission,
        ]);
    }

    public function getCommunityProperty()
    {
        return $this->getCommunityByEmail($this->community->email);
    }

    public function getAddressProperty()
    {
        return $this->getAddressByCommunityId($this->community->id);
    }

    public function getSubmissionProperty()
    {
        return $this->getSubmissionByCompetitionIDAndCommunityID($this->competition->id, $this->community->id);
    }

    public function retrieveCommunity()
    {
        $this->validate([
            'community.email' => 'required|email'
        ]);

        $this->community = $this->getCommunityProperty();
        $this->address = $this->getAddressProperty();

        $this->fill([
            'isRetrieved' => isset($this->community),
            'isSaved' => isset($this->community->id)
        ]);

        $this->dispatchBrowserEvent('notifyUser', [
            'isRetrieved' => $this->isRetrieved,
            'isSaved' => $this->isSaved
        ]);
    }

    public function checkProfileConpletion()
    {
        if (!isset($this->community->id)) {
            if ($this->community->checkCompletion() && $this->address->checkCompletion()) {
                $this->createCommunity(array_merge($this->community->attributesToArray(), ['password' => Hash::make($this->password)]), $this->address->attributesToArray(), []);
            } else {
                $this->dispatchBrowserEvent('alert', [
                    'type' => 'warning',
                    'message' => __("Please complete your Personal Information first")
                ]);
                return;
            }
        }
    }

    public function checkRecordValue($record)
    {
        switch ($this->category_code) {
            case 'E':
            case 'W':
                return !($record['usage'] && $record['charge']);
            case 'R':
            case 'UO':
                return !($record['value'] && $record['weight']);
        }
    }

    public function saveRecords()
    {
        if(!$this->submission->id)
            $this->submission->save();

        foreach ($this->records ?? [] as $record) {
            if ($this->checkRecordValue($record))
                continue;

            $bill = $this->getBillByMonthAndSubmission($record['month_id'], $this->submission->id);
            if(!$bill->id)
                $bill->save();

            $category = $this->getCategoryByBill($this->category_code, $bill->id);

            switch ($this->category_code) {
                case 'E':
                case 'W':
                    $category->usage = $record['usage'];
                    $category->charge = $record['charge'];
                    break;
                case 'R':
                case 'UO':
                    $category->value = $record['value'];
                    $category->weight = $record['weight'];
                    break;
            }

            $category->calculateCarbonEmission();
            $category->save();

            $bill->calculateStats();
            $bill->save();
        }

        $this->submission->calculateStats();
        $this->submission->save();
    }

    public function initRecords()
    {
        $category_information = $this->getSubmissionCategory('name', $this->current_tab);
        $this->category_symbol = $category_information->symbol;
        $this->category_code = $category_information->code;

        $this->records = $this->competition->months->map(function ($month) use ($category_information) {
            $record = [
                'month_id' => $month->id,
                'category' => $category_information->code,
            ];

            $bill = $this->submission->id ? $this->getBillByMonthAndSubmission($month->id, $this->submission->id) : null;

            switch ($category_information->code) {
                case 'E':
                case 'W':
                    return array_merge($record, [
                        'usage' => ($bill && $bill->{$category_information->name}) ? $bill->{$category_information->name}->usage : 0,
                        'charge' => ($bill && $bill->{$category_information->name}) ? $bill->{$category_information->name}->charge : 0,
                    ]);
                case 'R':
                case 'UO':
                    return array_merge($record, [
                        'value' => ($bill && $bill->{$category_information->name}) ? $bill->{$category_information->name}->value : 0,
                        'weight' => ($bill && $bill->{$category_information->name}) ? $bill->{$category_information->name}->weight : 0,
                    ]);
            }
        });
    }

    public function changeTab($tabIndex)
    {
        if (collect($this->tab_list)->doesntContain($tabIndex)) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => __("Please refresh the page")
            ]);
            return;
        }

        $this->current_tab = $tabIndex;

        if ($this->checkSubmissionCategory('name', $tabIndex)) {
            $this->checkProfileConpletion();

            if (!$this->submission->id) {
                $this->submission = $this->getSubmissionProperty();
            }

            $this->saveRecords();
            $this->initRecords();

            $this->dispatchBrowserEvent('changeTab', [
                'tab' => $this->current_tab
            ]);
        } else if ($tabIndex == 'personal') {

            $this->fill([
                'community' => $this->getCommunityProperty(),
                'address' => $this->getAddressProperty(),
            ]);

            $this->reset([
                'records',
                'category_symbol',
                'category_code',
            ]);

            $this->dispatchBrowserEvent('changeTab', [
                'tab' => $this->current_tab
            ]);
        }
    }

    public function submit()
    {
        if (!$this->submission->id) {
            $this->submission = $this->getSubmissionProperty();
        }

        $this->saveRecords();

        return redirect(route('community.form.success'));
    }

    public function render()
    {
        return view('livewire.community.contest.form');
    }
}
