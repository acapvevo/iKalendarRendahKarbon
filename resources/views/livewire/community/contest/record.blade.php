@push('styles')
@endpush

<div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered text-center">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Month') }}</th>
                    <th>{{ __('Total Carbon Emission') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submission->competition->months as $monthObj)
                    <tr>
                        <td>{{ $monthObj->getName() }}</td>
                        <td>{{ number_format($submission->getBillByMonthID($monthObj->id)->{$category_name}->carbon_emission ?? 0, 2) }}
                            kgCO<sub>2</sub></td>
                        <td>
                            <div class="btn-toolbar justify-content-center" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewMonthModal" wire:click.prevent='open({{ $monthObj->id }})'>
                                        <i data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('View Submission for') }} {{ $monthObj->getName() }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editSubmisssionModal"
                                        wire:click.prevent='open({{ $monthObj->id }})'>
                                        <i data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('Edit Submission for') }} {{ $monthObj->getName() }}"
                                            data-feather="edit-2"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- View Month Modal -->
    <div class="modal fade" id="viewMonthModal" tabindex="-1" aria-labelledby="viewMonthModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewMonthModalLabel">{{ __('View Submission for') }}
                        {{ $month ? $month->getName() : '' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="1">{{ __('Month') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ $month ? $month->getName() : '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="4" class="h3 text-center">{{ __('Submission Details') }}:
                                    {{ __($category_description) }}</th>
                            </tr>
                            @switch($category_name)
                                @case('electric')
                                @case('water')
                                    <tr>
                                        <th style="width: 20%">{{ __('Consumption') }}</th>
                                        <td class="text-center">{{ number_format((float) ${$category_name}->usage ?? 0, 2) }}
                                            {!! $category_symbol !!}
                                        </td>
                                        <th style="width: 20%">{{ __('Bill Charge') }}</th>
                                        <td class="text-center">RM
                                            {{ number_format((float) ${$category_name}->charge ?? 0, 2) }}
                                        </td>
                                    </tr>
                                @break

                                @case('recycle')
                                @case('used_oil')
                                    <tr>
                                        <th style="width: 20%">{{ __('Total Weight') }}</th>
                                        <td class="text-center">{{ number_format((float) ${$category_name}->weight ?? 0, 2) }}
                                            kg
                                        </td>
                                        <th style="width: 20%">{{ __('Total Sell Value') }}</th>
                                        <td class="text-center">RM
                                            {{ number_format((float) ${$category_name}->value ?? 0, 2) }}
                                        </td>
                                    </tr>
                                @break

                                @default
                            @endswitch
                            <tr>
                                <th colspan="1">{{ __('Carbon Emission') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ number_format((float) ${$category_name}->carbon_emission ?? 0, 2) }}
                                    kgCO<sub>2</sub></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Submission Modal -->
    <div class="modal fade" id="editSubmisssionModal" tabindex="-1" aria-labelledby="editSubmisssionModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editSubmisssionModalLabel">{{ __('Edit Submission for') }}
                        {{ $month ? $month->getName() : '' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="pt-3 pb-3">
                        <!-- Wizard navigation-->
                        <div class="nav nav-pills nav-justified flex-column flex-xl-row nav-wizard" id="cardTab"
                            role="tablist">

                            <!-- Wizard navigation item 1-->
                            <a class="nav-item nav-link active" id="wizard1-tab" href="#wizard1" data-bs-toggle="tab"
                                role="tab" aria-controls="wizard1" aria-selected="true"
                                wire:click.prevent="setTab(1)" wire:ignore.self>
                                {!! $errors->has($category_name . '.*') || $errors->has('evidence')
                                    ? '<div class="wizard-step-icon text-bg-danger">!</div>'
                                    : '<div class="wizard-step-icon">1</div>' !!}
                                <div class="wizard-step-text">
                                    <div class="wizard-step-text-name">{{ __($category_description) }}
                                    </div>
                                </div>
                            </a>

                            <!-- Wizard navigation item 2-->
                            <a class="nav-item nav-link" id="wizard2-tab" href="#wizard2" data-bs-toggle="tab"
                                role="tab" aria-controls="wizard2" aria-selected="true"
                                wire:click.prevent="setTab(2)" wire:ignore.self>
                                <div class="wizard-step-icon">2</div>
                                <div class="wizard-step-text">
                                    <div class="wizard-step-text-name">{{ __('Confirmation') }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <form>
                        <div class="tab-content" id="cardTabContent">

                            <!-- Wizard tab pane item 1-->
                            <div class="tab-pane py-5 py-xl-10 fade show active" id="wizard1" role="tabpanel"
                                aria-labelledby="wizard1-tab" wire:ignore.self>
                                <div class="row justify-content-center">
                                    <div class="col-xxl-11 col-xl-11">
                                        <h3 class="text-primary">{{ __('Step') }} 1</h3>

                                        @switch($category_name)
                                            @case('electric')
                                            @case('water')
                                                <h5 class="card-title mb-4">
                                                    {{ __('Insert your ' . $category_description . ' consumption and bill charge') }}
                                                </h5>

                                                <div class="mb-3 row">
                                                    <div class="col-xl-6">
                                                        <label for="{{ $category_name }}.usage"
                                                            class="form-label">{{ __('Consumption') }}</label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" required
                                                                class="form-control {{ $errors->has($category_name . '.usage') ? 'is-invalid' : '' }}"
                                                                id="{{ $category_name }}.usage"
                                                                aria-describedby="{{ $category_name }}.usage_desc"
                                                                wire:model.lazy='{{ $category_name }}.usage'
                                                                placeholder="{{ __('Enter your ' . $category_description . ' Consumption for') }} {{ $month ? $month->getName() : '' }}">
                                                            <span class="input-group-text"
                                                                id="{{ $category_name }}.usage_desc">
                                                                {!! $category_symbol !!}
                                                            </span>
                                                            @error($category_name . '.usage')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <label for="{{ $category_name }}.charge"
                                                            class="form-label">{{ __('Bill Charge') }}</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text"
                                                                id="{{ $category_name }}.charge_desc">RM</span>
                                                            <input type="number" required
                                                                class="form-control {{ $errors->has($category_name . '.charge') ? 'is-invalid' : '' }}"
                                                                id="{{ $category_name }}.charge"
                                                                aria-describedby="{{ $category_name }}.charge_desc"
                                                                wire:model.lazy='{{ $category_name }}.charge'
                                                                placeholder="{{ __('Enter your ' . $category_description . ' Bill Charge for') }} {{ $month ? $month->getName() : '' }}">
                                                            @error($category_name . '.charge')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('recycle')
                                            @case('used_oil')
                                                <h5 class="card-title mb-4">
                                                    {{ __('Insert your ' . $category_description . ' total weight and sell value') }}
                                                </h5>

                                                <div class="mb-3 row">
                                                    <div class="col-xl-6">
                                                        <label for="{{ $category_name }}.weight"
                                                            class="form-label">{{ __('Total Weight') }}</label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" required
                                                                class="form-control {{ $errors->has($category_name . '.weight') ? 'is-invalid' : '' }}"
                                                                id="{{ $category_name }}.weight"
                                                                aria-describedby="{{ $category_name }}.weight_desc"
                                                                wire:model.lazy='{{ $category_name }}.weight'
                                                                placeholder="{{ __('Enter your ' . $category_description . ' total weight for') }} {{ $month ? $month->getName() : '' }}">
                                                            <span class="input-group-text"
                                                                id="{{ $category_name }}.weight_desc">kg</span>
                                                            @error($category_name . '.weight')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <label for="{{ $category_name }}.value"
                                                            class="form-label">{{ __('Total Sell Value') }}</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text"
                                                                id="{{ $category_name }}.value_desc">RM</span>
                                                            <input type="number" required
                                                                class="form-control {{ $errors->has($category_name . '.value') ? 'is-invalid' : '' }}"
                                                                id="{{ $category_name }}.value"
                                                                aria-describedby="{{ $category_name }}.value_desc"
                                                                wire:model.lazy='{{ $category_name }}.value'
                                                                placeholder="{{ __('Enter your ' . $category_description . ' sell value for') }} {{ $month ? $month->getName() : '' }}">
                                                            @error($category_name . '.value')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @break

                                        @endswitch

                                    </div>
                                </div>
                            </div>

                            <!-- Wizard tab pane item 2-->
                            <div class="tab-pane py-5 py-xl-10 fade" id="wizard2" role="tabpanel"
                                aria-labelledby="wizard2-tab" wire:ignore.self>
                                <div class="row justify-content-center">
                                    <div class="col-xxl-11 col-xl-11">
                                        <h3 class="text-primary">{{ __('Step') }} 2</h3>
                                        <h5 class="card-title mb-4">
                                            {{ __('Review the following information and submit') }}</h5>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th colspan="1">{{ __('Month') }}</th>
                                                    <td colspan="3" class="text-center">
                                                        {{ $month ? $month->getName() : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" class="h3 text-center">
                                                        {{ __('Submission Details') }}:
                                                        {{ __($category_description) }}</th>
                                                </tr>
                                                @switch($category_name)
                                                    @case('electric')
                                                    @case('water')
                                                        <tr>
                                                            <th style="width: 20%">{{ __('Consumption') }}</th>
                                                            <td class="text-center">
                                                                {{ number_format((float) ${$category_name}->usage ?? 0, 2) }}
                                                                {!! $category_symbol !!}
                                                            </td>
                                                            <th style="width: 20%">{{ __('Bill Charge') }}</th>
                                                            <td class="text-center">RM
                                                                {{ number_format((float) ${$category_name}->charge ?? 0, 2) }}
                                                            </td>
                                                        </tr>
                                                    @break

                                                    @case('recycle')
                                                    @case('used_oil')
                                                        <tr>
                                                            <th style="width: 20%">{{ __('Total Weight') }}</th>
                                                            <td class="text-center">
                                                                {{ number_format((float) ${$category_name}->weight ?? 0, 2) }}
                                                                kg
                                                            </td>
                                                            <th style="width: 20%">{{ __('Total Sell Value') }}</th>
                                                            <td class="text-center">RM
                                                                {{ number_format((float) ${$category_name}->value ?? 0, 2) }}
                                                            </td>
                                                        </tr>
                                                    @break

                                                    @default
                                                @endswitch
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    @if ($tab_state !== 1)
                        <button type="button" class="btn btn-danger" id="previousTab"
                            wire:click.prevent="previousTab()">{!! __('pagination.previous') !!}</button>
                    @endif
                    @if ($tab_state === 2)
                        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"
                            wire:click.prevent="update()">
                            <span wire:loading.remove>{{ __('Save') }}</span>
                            <div wire:loading wire:target="update">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                {{ __('Saving...') }}
                            </div>
                        </button>
                    @else
                        <button type="button" class="btn btn-success" id="nextTab"
                            wire:click.prevent="nextTab()">{!! __('pagination.next') !!}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        const editSubmisssionModalEl = document.getElementById('editSubmisssionModal')
        editSubmisssionModalEl.addEventListener('hidden.bs.modal', event => {
            @this.emit('closeModal')
        })
        const viewMonthModalEl = document.getElementById('viewMonthModal')
        viewMonthModalEl.addEventListener('hidden.bs.modal', event => {
            @this.emit('closeModal')
        })

        Livewire.on('changeTab', tab_state => {
            const wizardTab = document.getElementById('wizard' + tab_state + '-tab');
            bootstrap.Tab.getOrCreateInstance(wizardTab).show();
        })
    </script>
@endpush
