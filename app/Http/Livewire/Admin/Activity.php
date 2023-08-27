<?php

namespace App\Http\Livewire\Admin;

use App\Models\Activity as ActivityModel;
use App\Models\Electronic;
use App\Models\Fabric;
use App\Models\Recycle;
use App\Models\UsedOil;
use App\Traits\ActivityTrait;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Traits\Livewire\CheckGuard;
use Livewire\Component;

class Activity extends Component
{
    use LivewireAlert, CheckGuard, ActivityTrait;

    protected $guard = 'admin';

    public ActivityModel $activity;
    public $activities;
    public $activity_categories;

    public UsedOil $used_oil;
    public Recycle $recycle;
    public Fabric $fabric;
    public Electronic $electronic;

    public $activity_id;

    public $isLoading = true;

    protected function getListeners()
    {
        return [
            'closeModal' => 'close',
            'delete'
        ];
    }

    protected function rules()
    {
        return [
            'activity.title' => 'required|string|max:255',
            'activity.date' => 'required|date',
            'used_oil.weight' => 'required|numeric|min:0',
            'used_oil.value' => 'required|numeric|min:0',
            'recycle.weight' => 'required|numeric|min:0',
            'recycle.value' => 'required|numeric|min:0',
            'fabric.weight' => 'required|numeric|min:0',
            'fabric.value' => 'required|numeric|min:0',
            'electronic.weight' => 'required|numeric|min:0',
            'electronic.value' => 'required|numeric|min:0',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($activities)
    {
        $this->fill($this->initModelByActivityCategory()->merge([
            'activities' => $activities,
            'activity' => $this->getActivityProperty(),
            'activity_categories' => $this->getActivityCategories()
        ]));
    }

    public function getActivityProperty()
    {
        return $this->getActivity($this->activity_id);
    }

    public function open($id)
    {
        $this->activity_id = $id;
        $this->activity = $this->getActivityProperty();

        $this->fill($this->activity->getAllActivityCategory());

        $this->isLoading = false;
    }

    public function close()
    {
        $this->activity_id = null;
        $this->activity = $this->getActivityProperty();

        $this->fill($this->initModelByActivityCategory());

        $this->isLoading = true;
    }

    public function askDelete($id)
    {
        $activity = $this->getActivity($id);

        $this->alert('warning', __('Warning'), [
            'inputAttributes' => [
                'id' => $id
             ],
            'position' => 'center',
            'timer' => null,
            'toast' => true,
            'text' => __("alerts.activity_delete_confirmation", ['title' => $activity->title]),
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'cancelButtonText' => __('Cancel'),
            'confirmButtonText' => __('Confirm'),
            'onConfirmed' => 'delete',
            'onDismissed' => '',
        ]);
    }

    public function create()
    {
        $this->validate();

        $this->activity->save();
        foreach($this->activity_categories as $category){
            $this->{$category['name']}->calculateCarbonEmission();
            $this->activity->{$category['name']}()->save($this->{$category['name']});
        }

        $this->activity->calculateTotalCarbonEmission();

        return redirect(route('admin.activity.list'))->with('success', __('alerts.activity_create', ['title' => $this->activity->title]));
    }

    public function update()
    {
        $this->validate();

        $this->activity->save();
        foreach($this->activity_categories as $category){
            $this->{$category['name']}->calculateCarbonEmission();
            $this->{$category['name']}->save();
        }

        $this->activity->calculateTotalCarbonEmission();

        return redirect(route('admin.activity.list'))->with('success', __('alerts.activity_update', ['title' => $this->activity->title]));
    }

    public function delete($response)
    {
        $activity = $this->getActivity($response['data']['inputAttributes']['id']);

        $activity->deleteCategory();
        $activity->delete();

        return redirect(route('admin.activity.list'))->with('success', __('alerts.activity_delete'));
    }

    public function hydrate()
    {
        $this->emit('flatpickr');
    }

    public function render()
    {
        $this->activity_categories = $this->getActivityCategories();

        return view('livewire.admin.activity');
    }
}
