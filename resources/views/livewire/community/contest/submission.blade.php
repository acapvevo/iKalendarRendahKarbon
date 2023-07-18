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
                        <td>{{ $submission->getTotalCarbonEmissionByMonthID($monthObj->id) }} kgCO<sub>2</sub></td>
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
    <div class="modal fade" id="viewMonthModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewMonthModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewMonthModalLabel">{{ __('View Submission for') }}
                        {{ $month ? $month->getName() : '' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
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
                                <th colspan="4" class="h3 text-center">{{ __('Submission Details') }}</th>
                            </tr>
                            <tr>
                                <th colspan="4" class="h3 text-center">{{ __('Electric') }}</th>
                            </tr>
                            <tr>
                                <th style="width: 20%">{{ __('Usage') }}</th>
                                <td class="text-center">{{ number_format((float) $electric->usage ?? 0, 2) }} kWh</td>
                                <th style="width: 20%">{{ __('Bill Charge') }}</th>
                                <td class="text-center">RM {{ number_format((float) $electric->charge ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Evidence') }}</th>
                                <td colspan="3" class="text-center">
                                    @if ($electric->evidence ?? null)
                                        <form action="{{ route('community.contest.submission.download') }}"
                                            method="post" target="_blank">
                                            @csrf

                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                            <button type="submit" class="btn btn-link" name="type"
                                                value="electric">{{ $electric->evidence }}</button>
                                        </form>
                                    @else
                                        {{ __('No Evidence') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Carbon Emission') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ number_format((float) $electric->carbon_emission ?? 0, 2) }}
                                    kgCO<sub>2</sub></td>
                            </tr>
                            <tr>
                                <th colspan="4" class="h3 text-center">{{ __('Water') }}</th>
                            </tr>
                            <tr>
                                <th style="width: 20%">{{ __('Usage') }}</th>
                                <td class="text-center">{{ number_format((float) $water->usage ?? 0, 2) }}
                                    m<sup>3</sup>
                                </td>
                                <th style="width: 20%">{{ __('Bill Charge') }}</th>
                                <td class="text-center">RM {{ number_format((float) $water->charge ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Evidence') }}</th>
                                <td colspan="3" class="text-center">
                                    @if ($water->evidence ?? null)
                                        <form action="{{ route('community.contest.submission.download') }}"
                                            method="post" target="_blank">
                                            @csrf

                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                            <button type="submit" class="btn btn-link" name="type"
                                                value="water">{{ $water->evidence }}</button>
                                        </form>
                                    @else
                                        {{ __('No Evidence') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Carbon Emission') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ number_format((float) $water->carbon_emission ?? 0, 2) }}
                                    kgCO<sub>2</sub></td>
                            </tr>
                            <tr>
                                <th colspan="4" class="h3 text-center">{{ __('Recycle') }}</th>
                            </tr>
                            <tr>
                                <th style="width: 20%">{{ __('Total Weight') }}</th>
                                <td class="text-center">{{ number_format((float) $recycle->weight ?? 0, 2) }} kg</td>
                                <th style="width: 20%">{{ __('Total Sell Value') }}</th>
                                <td class="text-center">RM {{ number_format((float) $recycle->value ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Evidence') }}</th>
                                <td colspan="3" class="text-center">
                                    @if ($recycle->evidence ?? null)
                                        <form action="{{ route('community.contest.submission.download') }}"
                                            method="post" target="_blank">
                                            @csrf

                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                            <button type="submit" class="btn btn-link" name="type"
                                                value="recycle">{{ $recycle->evidence }}</button>
                                        </form>
                                    @else
                                        {{ __('No Evidence') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Carbon Emission') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ number_format((float) $recycle->carbon_emission ?? 0, 2) }}
                                    kgCO<sub>2</sub></td>
                            </tr>
                            <tr>
                                <th colspan="4" class="h3 text-center">{{ __('Used Oil') }}</th>
                            </tr>
                            <tr>
                                <th style="width: 20%">{{ __('Total Weight') }}</th>
                                <td class="text-center">{{ number_format((float) $used_oil->weight ?? 0, 2) }} kg</td>
                                <th style="width: 20%">{{ __('Total Sell Value') }}</th>
                                <td class="text-center">RM {{ number_format((float) $used_oil->value ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Evidence') }}</th>
                                <td colspan="3" class="text-center">
                                    @if ($used_oil->evidence ?? null)
                                        <form action="{{ route('community.contest.submission.download') }}"
                                            method="post" target="_blank">
                                            @csrf

                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                            <button type="submit" class="btn btn-link" name="type"
                                                value="used_oil">{{ $used_oil->evidence }}</button>
                                        </form>
                                    @else
                                        {{ __('No Evidence') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Carbon Emission') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ number_format($used_oil->carbon_emission ?? 0, 2) }}
                                    kgCO<sub>2</sub></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click.prevent="close()">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Submission Modal -->
    <div class="modal fade" id="editSubmisssionModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="editSubmisssionModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editSubmisssionModalLabel">{{ __('Edit Submission for') }}
                        {{ $month ? $month->getName() : '' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="pt-3 pb-3">
                        <!-- Wizard navigation-->
                        <div class="nav nav-pills nav-justified flex-column flex-xl-row nav-wizard" id="cardTab"
                            role="tablist">
                            <!-- Wizard navigation item 1-->
                            <a class="nav-item nav-link active" id="wizard1-tab" href="#wizard1"
                                data-bs-toggle="tab" role="tab" aria-controls="wizard1" aria-selected="true"
                                wire:click.prevent="setTab(1)" wire:ignore.self>
                                <div class="wizard-step-icon">1</div>
                                <div class="wizard-step-text">
                                    <div class="wizard-step-text-name">{{ __('Electric') }}</div>
                                </div>
                            </a>
                            <!-- Wizard navigation item 2-->
                            <a class="nav-item nav-link" id="wizard2-tab" href="#wizard2" data-bs-toggle="tab"
                                role="tab" aria-controls="wizard2" aria-selected="true"
                                wire:click.prevent="setTab(2)" wire:ignore.self 2>
                                <div class="wizard-step-icon">2</div>
                                <div class="wizard-step-text">
                                    <div class="wizard-step-text-name">{{ __('Water') }}</div>
                                </div>
                            </a>
                            <!-- Wizard navigation item 3-->
                            <a class="nav-item nav-link" id="wizard3-tab" href="#wizard3" data-bs-toggle="tab"
                                role="tab" aria-controls="wizard3" aria-selected="true"
                                wire:click.prevent="setTab(3)" wire:ignore.self>
                                <div class="wizard-step-icon">3</div>
                                <div class="wizard-step-text">
                                    <div class="wizard-step-text-name">{{ __('Recycle') }}</div>
                                </div>
                            </a>
                            <!-- Wizard navigation item 4-->
                            <a class="nav-item nav-link" id="wizard4-tab" href="#wizard4" data-bs-toggle="tab"
                                role="tab" aria-controls="wizard4" aria-selected="true"
                                wire:click.prevent="setTab(4)" wire:ignore.self>
                                <div class="wizard-step-icon">4</div>
                                <div class="wizard-step-text">
                                    <div class="wizard-step-text-name">{{ __('Used Oil') }}</div>
                                </div>
                            </a>
                            <!-- Wizard navigation item 5-->
                            <a class="nav-item nav-link" id="wizard5-tab" href="#wizard5" data-bs-toggle="tab"
                                role="tab" aria-controls="wizard5" aria-selected="true"
                                wire:click.prevent="setTab(5)" wire:ignore.self>
                                <div class="wizard-step-icon">5</div>
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
                                        <h5 class="card-title mb-4">
                                            {{ __('Insert your Electric consumption and bill charge') }}</h5>

                                        <div class="mb-3 row">
                                            <div class="col-xl-6">
                                                <label for="electric.usage"
                                                    class="form-label">{{ __('Consumption') }}</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" required
                                                        class="form-control {{ $errors->has('electric.usage') ? 'is-invalid' : '' }}"
                                                        id="electric.usage" aria-describedby="electric.usage_desc"
                                                        wire:model.lazy='electric.usage'
                                                        placeholder="{{ __('Enter your Electric Consumption for') }} {{ $month ? $month->getName() : '' }}">
                                                    <span class="input-group-text" id="electric.usage_desc">kWh</span>
                                                    @error('electric.usage')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="electric.charge"
                                                    class="form-label">{{ __('Bill Charge') }}</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="electric.charge_desc">RM</span>
                                                    <input type="number" required
                                                        class="form-control {{ $errors->has('electric.charge') ? 'is-invalid' : '' }}"
                                                        id="electric.charge" aria-describedby="electric.charge_desc"
                                                        wire:model.lazy='electric.charge'
                                                        placeholder="{{ __('Enter your Electric Bill Charge for') }} {{ $month ? $month->getName() : '' }}">
                                                    @error('electric.charge')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="electric_evidence_label"
                                                class="form-label">{{ __('Evidence') }}</label>
                                            <div class="input-group custom-file-button" id="electric_evidence_label">
                                                <label class="input-group-text" for="electric_evidence"
                                                    role="button">{{ __('Browse') }}</label>
                                                <label for="electric_evidence"
                                                    class="form-control {{ $errors->has('electric_evidence') ? 'is-invalid' : '' }}"
                                                    id="eviden-electric-label" role="button"
                                                    evidence='Electric'>{{ $electric_evidence_label }}</label>
                                                <input type="file" required
                                                    class="evidenceInput d-none form-control" id="electric_evidence"
                                                    name='electric' wire:model="electric_evidence">
                                                @error('electric_evidence')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

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
                                            {{ __('Insert your Water consumption and bill charge') }}</h5>

                                        <div class="mb-3 row">
                                            <div class="col-xl-6">
                                                <label for="water.usage"
                                                    class="form-label">{{ __('Consumption') }}</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" required
                                                        class="form-control {{ $errors->has('water.usage') ? 'is-invalid' : '' }}"
                                                        id="water.usage" aria-describedby="water.usage_desc"
                                                        wire:model.lazy='water.usage'
                                                        placeholder="{{ __('Enter your Water Consumption for') }} {{ $month ? $month->getName() : '' }}">
                                                    <span class="input-group-text"
                                                        id="water.usage_desc">m<sup>3</sup></span>
                                                    @error('water.usage')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="water.charge"
                                                    class="form-label">{{ __('Water Bill Charge') }}</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="water.charge_desc">RM</span>
                                                    <input type="number" required
                                                        class="form-control {{ $errors->has('water.charge') ? 'is-invalid' : '' }}"
                                                        id="water.charge" aria-describedby="water.charge_desc"
                                                        wire:model.lazy='water.charge'
                                                        placeholder="{{ __('Enter your Water Bill Charge for') }} {{ $month ? $month->getName() : '' }}">
                                                    @error('water.charge')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="water_evidence_label"
                                                class="form-label">{{ __('Evidence') }}</label>
                                            <div class="input-group custom-file-button" id="water_evidence_label">
                                                <label class="input-group-text" for="water_evidence"
                                                    role="button">{{ __('Browse') }}</label>
                                                <label for="water_evidence"
                                                    class="form-control {{ $errors->has('water_evidence') ? 'is-invalid' : '' }}"
                                                    id="eviden-water-label"
                                                    role="button">{{ $water_evidence_label }}</label>
                                                <input type="file" required
                                                    class="evidenceInput d-none form-control" id="water_evidence"
                                                    name='water' wire:model="water_evidence">
                                                @error('water_evidence')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Wizard tab pane item 3-->
                            <div class="tab-pane py-5 py-xl-10 fade" id="wizard3" role="tabpanel"
                                aria-labelledby="wizard3-tab" wire:ignore.self>
                                <div class="row justify-content-center">
                                    <div class="col-xxl-11 col-xl-11">
                                        <h3 class="text-primary">{{ __('Step') }} 3</h3>
                                        <h5 class="card-title mb-4">
                                            {{ __('Insert your Recycle total weight and sell value') }}</h5>
                                        </h5>

                                        <div class="mb-3 row">
                                            <div class="col-xl-6">
                                                <label for="recycle.weight"
                                                    class="form-label">{{ __('Total Weight') }}</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" required
                                                        class="form-control {{ $errors->has('recycle.weight') ? 'is-invalid' : '' }}"
                                                        id="recycle.weight" aria-describedby="recycle.weight_desc"
                                                        wire:model.lazy='recycle.weight'
                                                        placeholder="{{ __('Enter your Recycle total weight for') }} {{ $month ? $month->getName() : '' }}">
                                                    <span class="input-group-text" id="recycle.weight_desc">kg</span>
                                                    @error('recycle.weight')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="recycle.value"
                                                    class="form-label">{{ __('Total Sell Value') }}</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="recycle.value_desc">RM</span>
                                                    <input type="number" required
                                                        class="form-control {{ $errors->has('recycle.value') ? 'is-invalid' : '' }}"
                                                        id="recycle.value" aria-describedby="recycle.value_desc"
                                                        wire:model.lazy='recycle.value'
                                                        placeholder="{{ __('Enter your Recycle sell value for') }} {{ $month ? $month->getName() : '' }}">
                                                    @error('recycle.value')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="recycle_evidence_label"
                                                class="form-label">{{ __('Evidence') }}</label>
                                            <div class="input-group custom-file-button" id="recycle_evidence_label">
                                                <label class="input-group-text" for="recycle_evidence"
                                                    role="button">{{ __('Browse') }}</label>
                                                <label for="recycle_evidence"
                                                    class="form-control {{ $errors->has('recycle_evidence') ? 'is-invalid' : '' }}"
                                                    id="eviden-recycle-label"
                                                    role="button">{{ $recycle_evidence_label }}</label>
                                                <input type="file" required
                                                    class="evidenceInput d-none form-control" id="recycle_evidence"
                                                    name='recycle' wire:model="recycle_evidence">
                                                @error('recycle_evidence')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Wizard tab pane item 4-->
                            <div class="tab-pane py-5 py-xl-10 fade" id="wizard4" role="tabpanel"
                                aria-labelledby="wizard4-tab" wire:ignore.self>
                                <div class="row justify-content-center">
                                    <div class="col-xxl-11 col-xl-11">
                                        <h3 class="text-primary">{{ __('Step') }} 4</h3>
                                        <h5 class="card-title mb-4">
                                            {{ __('Insert your Used Oil total weight and sell value') }}</h5>

                                        <div class="mb-3 row">
                                            <div class="col-xl-6">
                                                <label for="used_oil.weight"
                                                    class="form-label">{{ __('Total Weight') }}</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" required
                                                        class="form-control {{ $errors->has('used_oil.weight') ? 'is-invalid' : '' }}"
                                                        id="used_oil.weight" aria-describedby="used_oil.weight_desc"
                                                        wire:model.lazy='used_oil.weight'
                                                        placeholder="{{ __('Enter your Used Oil total weight for') }} {{ $month ? $month->getName() : '' }}">
                                                    <span class="input-group-text" id="used_oil.weight_desc">kg</span>
                                                    @error('used_oil.weight')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="used_oil.value"
                                                    class="form-label">{{ __('Total Sell Value') }}</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="used_oil.value_desc">RM</span>
                                                    <input type="number" required
                                                        class="form-control {{ $errors->has('used_oil.value') ? 'is-invalid' : '' }}"
                                                        id="used_oil.value" aria-describedby="used_oil.value_desc"
                                                        wire:model.lazy='used_oil.value'
                                                        placeholder="{{ __('Enter your Used Oil sell value for') }} {{ $month ? $month->getName() : '' }}">
                                                    @error('used_oil.value')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="used_oil_evidence_label"
                                                class="form-label">{{ __('Evidence') }}</label>
                                            <div class="input-group custom-file-button" id="used_oil_evidence_label">
                                                <label class="input-group-text" for="used_oil_evidence"
                                                    role="button">{{ __('Browse') }}</label>
                                                <label for="used_oil_evidence"
                                                    class="form-control {{ $errors->has('used_oil_evidence') ? 'is-invalid' : '' }}"
                                                    id="eviden-used_oil-label"
                                                    role="button">{{ $used_oil_evidence_label }}</label>
                                                <input type="file" required
                                                    class="evidenceInput d-none form-control" id="used_oil_evidence"
                                                    name='used_oil' wire:model="used_oil_evidence">
                                                @error('used_oil_evidence')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Wizard tab pane item 5-->
                            <div class="tab-pane py-5 py-xl-10 fade" id="wizard5" role="tabpanel"
                                aria-labelledby="wizard5-tab" wire:ignore.self>
                                <div class="row justify-content-center">
                                    <div class="col-xxl-11 col-xl-11">
                                        <h3 class="text-primary">{{ __('Step') }} 5</h3>
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
                                                        {{ __('Submission Details') }}</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" class="h3 text-center">{{ __('Electric') }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 20%">{{ __('Usage') }}</th>
                                                    <td class="text-center">
                                                        {{ number_format((float) $electric->usage ?? 0, 2) }} kWh</td>
                                                    <th style="width: 20%">{{ __('Bill Charge') }}</th>
                                                    <td class="text-center">RM
                                                        {{ number_format((float) $electric->charge ?? 0, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="1">{{ __('Evidence') }}</th>
                                                    <td colspan="3" class="text-center">
                                                        @if ($electric_evidence)
                                                            {{ $electric_evidence->getClientOriginalName() }}
                                                        @else
                                                            {{ __('No Evidence') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" class="h3 text-center">{{ __('Water') }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 20%">{{ __('Usage') }}</th>
                                                    <td class="text-center">
                                                        {{ number_format((float) $water->usage ?? 0, 2) }}
                                                        m<sup>3</sup>
                                                    </td>
                                                    <th style="width: 20%">{{ __('Bill Charge') }}</th>
                                                    <td class="text-center">RM
                                                        {{ number_format((float) $water->charge ?? 0, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="1">{{ __('Evidence') }}</th>
                                                    <td colspan="3" class="text-center">
                                                        @if ($water_evidence)
                                                            {{ $water_evidence->getClientOriginalName() }}
                                                        @else
                                                            {{ __('No Evidence') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" class="h3 text-center">{{ __('Recycle') }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 20%">{{ __('Total Weight') }}</th>
                                                    <td class="text-center">
                                                        {{ number_format((float) $recycle->weight ?? 0, 2) }} kg</td>
                                                    <th style="width: 20%">{{ __('Total Sell Value') }}</th>
                                                    <td class="text-center">RM
                                                        {{ number_format((float) $recycle->value ?? 0, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="1">{{ __('Evidence') }}</th>
                                                    <td colspan="3" class="text-center">
                                                        @if ($recycle_evidence)
                                                            {{ $recycle_evidence->getClientOriginalName() }}
                                                        @else
                                                            {{ __('No Evidence') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" class="h3 text-center">{{ __('Used Oil') }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 20%">{{ __('Total Weight') }}</th>
                                                    <td class="text-center">
                                                        {{ number_format((float) $used_oil->weight ?? 0, 2) }} kg</td>
                                                    <th style="width: 20%">{{ __('Total Sell Value') }}</th>
                                                    <td class="text-center">RM
                                                        {{ number_format((float) $used_oil->value ?? 0, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="1">{{ __('Evidence') }}</th>
                                                    <td colspan="3" class="text-center">
                                                        @if ($used_oil_evidence)
                                                            {{ $used_oil_evidence->getClientOriginalName() }}
                                                        @else
                                                            {{ __('No Evidence') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click.prevent="close()">{{ __('Close') }}</button>
                    @if ($tab_state !== 1)
                        <button type="button" class="btn btn-danger" id="previousTab"
                            wire:click.prevent="previousTab()">{!! __('pagination.previous') !!}</button>
                    @endif
                    @if ($tab_state === 5)
                        <button type="submit" class="btn btn-primary"
                            wire:click.prevent="update()">{{ __('Save') }}</button>
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
            Livewire.emit('closeModal')
        })

        // $('.evidenceInput').change(function(e) {
        //     Livewire.emit('changePlaceholder')
        // });

        Livewire.on('changeTab', tab_state => {
            const wizardTab = document.getElementById('wizard' + tab_state + '-tab');
            bootstrap.Tab.getOrCreateInstance(wizardTab).show();
        })
    </script>
@endpush
