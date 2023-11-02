@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    @laravelTelInputStyles

    <style>
        table {
            min-width: 576px;
        }
    </style>
@endpush

<div>
    <!-- Wizard navigation-->
    <ul class="nav nav-pills nav-justified flex-column flex-xl-row nav-wizard" id="cardTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button wire:ignore.self class="nav-link active" data-bs-toggle="tab" id="personal-tab"
                data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true"
                wire:ignore.self disabled>
                <div class="wizard-step-icon">1</div>
                <div class="wizard-step-text">
                    <div class="wizard-step-text-name">{{ __('Account Creation') }}</div>
                    <div class="wizard-step-text-details">{{ __('Basic details and information') }}</div>
                </div>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="electric-tab" data-bs-toggle="tab" data-bs-target="#electric" type="button"
                role="tab" aria-controls="electric" aria-selected="false" wire:ignore.self disabled>
                <div class="wizard-step-icon">2</div>
                <div class="wizard-step-text">
                    <div class="wizard-step-text-name">{{ __('Electric Record') }}</div>
                    <div class="wizard-step-text-details">{{ __('Record Bill and Consumption for Electric') }}</div>
                </div>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="water-tab" data-bs-toggle="tab" data-bs-target="#water" type="button"
                role="tab" aria-controls="water" aria-selected="false" wire:ignore.self disabled>
                <div class="wizard-step-icon">3</div>
                <div class="wizard-step-text">
                    <div class="wizard-step-text-name">{{ __('Water Record') }}</div>
                    <div class="wizard-step-text-details">{{ __('Record Bill and Consumption for Water') }}</div>
                </div>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="recycle-tab" data-bs-toggle="tab" data-bs-target="#recycle" type="button"
                role="tab" aria-controls="recycle" aria-selected="false" wire:ignore.self disabled>
                <div class="wizard-step-icon">4</div>
                <div class="wizard-step-text">
                    <div class="wizard-step-text-name">{{ __('Recycle Record') }}</div>
                    <div class="wizard-step-text-details">{{ __('Record Total Sell Value and Weight for Recycle') }}
                    </div>
                </div>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="used_oil-tab" data-bs-toggle="tab" data-bs-target="#used_oil" type="button"
                role="tab" aria-controls="used_oil" aria-selected="false" wire:ignore.self disabled>
                <div class="wizard-step-icon">5</div>
                <div class="wizard-step-text">
                    <div class="wizard-step-text-name">{{ __('Used Oil Record') }}</div>
                    <div class="wizard-step-text-details">{{ __('Record Total Sell Value and Weight for Used Oil') }}
                    </div>
                </div>
            </button>
        </li>
    </ul>

    <div class="tab-content py-2" id="cardTabContent">

        <div class="tab-pane py-xl-10 fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab"
            tabindex="0" wire:ignore.self>
            <div class="px-5">

                <h3 class="text-primary">{{ __('Step') }} 1</h3>
                <h5 class="card-title mb-4">{{ __('Enter your personal information') }}</h5>

                <div class="row">
                    <div class="col-lg-6">
                        <label class="form-label" for="community_email">{{ __('Email Address') }}</label>
                        <div class="input-group mb-3">
                            <input type="email" id="community_email" wire:model='community.email'
                                class="form-control {{ $errors->has('community.email') ? 'is-invalid' : '' }}"
                                placeholder="{{ __('Enter Your Email Address') }} required"
                                aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="button" wire:click='retrieveCommunity'
                                id="button-addon2">
                                <span wire:loading.remove>{{ __('Retrieve') }}</span>
                                <div wire:loading wire:target='retrieveCommunity'>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    {{ __('Retrieve') }}
                                </div>
                            </button>
                            @error('community.email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="community_username">{{ __('Username') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('community.username') ? 'is-invalid' : '' }}"
                                id="community_username" wire:model='community.username'
                                placeholder="{{ __('Enter Your Username') }}" aria-describedby="usernameHelpBlock"
                                {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }} required />
                            <div id="usernameHelpBlock" class="form-text">
                                {{ __('The Username will be used for your login authentication') }}
                            </div>
                            @error('community.username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 row">
                            <div class="col-lg-6">
                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                <input type="password"
                                    class="form-control password {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    id="password" wire:model='password'
                                    placeholder="{{ __('Enter Your Password') }}"
                                    aria-describedby="passwordHelpBlock"
                                    {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }} />
                                <div id="passwordHelpBlock" class="form-text">
                                    {{ __('Your password must be more than 8 characters') }}
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label"
                                    for="password_confirmation">{{ __('Password Confirmation') }}</label>
                                <input type="password"
                                    class="form-control password {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                    id="password_confirmation" wire:model='password_confirmation'
                                    placeholder="{{ __('Enter Your Password Again') }}"
                                    {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }} />
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="community_name">{{ __('Name') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('community.name') ? 'is-invalid' : '' }}"
                                id="community_name" wire:model='community.name'
                                placeholder="{{ __('Enter Your Name') }}"
                                oninput="this.value = this.value.toUpperCase()" required
                                {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }} />
                            @error('community.name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 row">
                            <div class="col-lg-6">
                                <label class="form-label"
                                    for="community_identification_number">{{ __('Identification Card Number') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('community.identification_number') ? 'is-invalid' : '' }}"
                                    id="community_identification_number" wire:model='community.identification_number'
                                    placeholder="{{ __('Enter Your Identification Card Number') }}" required
                                    {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }} />
                                @error('community.identification_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label"
                                    for="community_phone_number">{{ __('Phone Number') }}</label>
                                <x-tel-input wire:model="community.phone_number" id="community_phone_number"
                                    class="form-control community_phone_number"
                                    placeholder="{{ __('Enter Your Phone Number') }}" required disabled />
                                @error('community.phone_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">

                        <div class="mb-3">
                            <label for="address.category" class="form-label">{{ __('Category') }}</label>
                            <select class="form-select {{ $errors->has('address.category') ? 'is-invalid' : '' }}"
                                id="address.category" aria-label="Default select example"
                                wire:model="address.category" required
                                {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }}>
                                <option selected value="">{{ __('Choose Address Category') }}</option>
                                @foreach (DB::table('address_category')->get() as $category)
                                    <option value="{{ $category->code }}" wire:key="category-{{ $category->code }}">
                                        {{ strtoupper(__($category->name)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('address.category')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address.line_1" class="form-label">{{ __('Address Line 1') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('address.line_1') ? 'is-invalid' : '' }}"
                                id="address.line_1" wire:model.lazy="address.line_1"
                                placeholder="{{ __('Enter Your Address Line 1') }}"
                                oninput="this.value = this.value.toUpperCase()" required
                                {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }}>
                            @error('address.line_1')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address.line_2" class="form-label">{{ __('Address Line 2') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('address.line_2') ? 'is-invalid' : '' }}"
                                id="address.line_2" wire:model.lazy="address.line_2"
                                placeholder="{{ __('Enter Your Address Line 2') }}"
                                oninput="this.value = this.value.toUpperCase()" required
                                {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }}>
                            @error('address.line_2')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address.line_3" class="form-label">{{ __('Address Line 3') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('address.line_3') ? 'is-invalid' : '' }}"
                                id="address.line_3" wire:model.lazy="address.line_3"
                                placeholder="{{ __('Enter Your Address Line 3') }}"
                                oninput="this.value = this.value.toUpperCase()"
                                {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }}>
                            @error('address.line_3')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 row">
                            <div class="col-12 col-lg-6">
                                <label for="address.postcode" class="form-label">{{ __('Postcode') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('address.postcode') ? 'is-invalid' : '' }}"
                                    id="address.postcode" wire:model.lazy="address.postcode"
                                    placeholder="{{ __('Enter Your Postcode') }}" required
                                    {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }}>
                                @error('address.postcode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="address.city" class="form-label">{{ __('City') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('address.city') ? 'is-invalid' : '' }}"
                                    id="address.city" wire:model.lazy="address.city"
                                    placeholder="{{ __('Enter Your City') }}"
                                    oninput="this.value = this.value.toUpperCase()" required
                                    {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }}>
                                @error('address.city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-12 col-lg-6">
                                <label for="address.state" class="form-label">{{ __('State') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('address.state') ? 'is-invalid' : '' }}"
                                    id="address.state" wire:model.lazy="address.state"
                                    oninput="this.value = this.value.toUpperCase()"
                                    placeholder="{{ __('Enter Your State') }}" readonly
                                    {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }}>
                                @error('address.state')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="address.country" class="form-label">{{ __('Country') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('address.country') ? 'is-invalid' : '' }}"
                                    id="address.country" wire:model.lazy="address.country"
                                    oninput="this.value = this.value.toUpperCase()"
                                    placeholder="{{ __('Enter Your Country') }}" readonly
                                    {{ $isRetrieved ? ($isSaved ? 'disabled' : '') : 'disabled' }}>
                                @error('address.country')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <hr class="my-4" />
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" type="button" wire:click='changeTab("electric")'>
                        <span wire:loading.remove>{!! __('pagination.next') !!}</span>
                        <div wire:loading wire:target='changeTab("electric")'>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {!! __('pagination.next') !!}
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <div class="tab-pane py-xl-10 fade" id="electric" role="tabpanel" aria-labelledby="electric-tab"
            tabindex="0" wire:ignore.self>
            <div class="px-5">

                <h3 class="text-primary">{{ __('Step') }} 2</h3>
                <h5 class="card-title mb-4">{{ __('Insert your Electric consumption and bill charge') }}</h5>

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr class="table-primary">
                                <th>{{ __('Month') }}</th>
                                <th>{{ __('Bill Charge') }}</th>
                                <th>{{ __('Consumption') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competition->months as $m => $month)
                                <tr>
                                    <td data-th="{{ __('Month') }}">{{ $month->getName() }}</td>
                                    <td data-th="{{ __('Bill Charge') }}">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"
                                                id="records_{{ $m }}_charge">RM</span>
                                            <input type="number" wire:model='records.{{ $m }}.charge'
                                                id="records_{{ $m }}_charge"
                                                class="form-control {{ $errors->has('records.' . $m . '.charge') ? 'is-invalid' : '' }}"
                                                placeholder="{{ __('Enter your Electric Bill Charge for') }} {{ $month->getName() }}">
                                        </div>
                                        @error('records.' . $m . '.charge')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                    <td data-th="{{ __('Consumption') }}">
                                        <div class="input-group mb-3">
                                            <input type="number" wire:model='records.{{ $m }}.usage'
                                                id="records_{{ $m }}_usage"
                                                class="form-control {{ $errors->has('records.' . $m . '.usage') ? 'is-invalid' : '' }}"
                                                placeholder="{{ __('Enter your Electric Consumption for') }} {{ $month->getName() }}">
                                            <span class="input-group-text"
                                                id="records_{{ $m }}_usage">{!! $category_symbol !!}</span>
                                        </div>
                                        @error('records.' . $m . '.usage')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr class="my-4" />
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary-soft" type="button" wire:click='changeTab("personal")'>
                        <span wire:loading.remove>{!! __('pagination.previous') !!}</span>
                        <div wire:loading wire:target='changeTab("personal")'>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {!! __('pagination.previous') !!}
                        </div>
                    </button>
                    <button class="btn btn-primary" type="button" wire:click='changeTab("water")'>
                        <span wire:loading.remove>{!! __('pagination.next') !!}</span>
                        <div wire:loading wire:target='changeTab("water")'>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {!! __('pagination.next') !!}
                        </div>
                    </button>
                </div>

            </div>
        </div>

        <div class="tab-pane py-xl-10 fade" id="water" role="tabpanel" aria-labelledby="water-tab"
            tabindex="0" wire:ignore.self>
            <div class="px-5">

                <h3 class="text-primary">{{ __('Step') }} 3</h3>
                <h5 class="card-title mb-4">{{ __('Insert your Water consumption and bill charge') }}</h5>

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr class="table-primary">
                                <th>{{ __('Month') }}</th>
                                <th>{{ __('Bill Charge') }}</th>
                                <th>{{ __('Consumption') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competition->months as $m => $month)
                                <tr>
                                    <td>{{ $month->getName() }}</td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"
                                                id="records_{{ $m }}_charge">RM</span>
                                            <input type="number" wire:model='records.{{ $m }}.charge'
                                                id="records_{{ $m }}_charge"
                                                class="form-control {{ $errors->has('records.' . $m . '.charge') ? 'is-invalid' : '' }}"
                                                placeholder="{{ __('Enter your Water Bill Charge for') }} {{ $month->getName() }}">
                                        </div>
                                        @error('records.' . $m . '.charge')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" wire:model='records.{{ $m }}.usage'
                                                id="records_{{ $m }}_usage"
                                                class="form-control {{ $errors->has('records.' . $m . '.usage') ? 'is-invalid' : '' }}"
                                                placeholder="{{ __('Enter your Water Consumption for') }} {{ $month->getName() }}">
                                            <span class="input-group-text"
                                                id="records_{{ $m }}_usage">{!! $category_symbol !!}</span>
                                        </div>
                                        @error('records.' . $m . '.usage')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr class="my-4" />
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary-soft" type="button" wire:click='changeTab("electric")'>
                        <span wire:loading.remove>{!! __('pagination.previous') !!}</span>
                        <div wire:loading wire:target='changeTab("electric")'>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {!! __('pagination.previous') !!}
                        </div>
                    </button>
                    <button class="btn btn-primary" type="button" wire:click='changeTab("recycle")'>
                        <span wire:loading.remove>{!! __('pagination.next') !!}</span>
                        <div wire:loading wire:target='changeTab("recycle")'>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {!! __('pagination.next') !!}
                        </div>
                    </button>
                </div>

            </div>
        </div>

        <div class="tab-pane py-xl-10 fade" id="recycle" role="tabpanel" aria-labelledby="recycle-tab"
            tabindex="0" wire:ignore.self>
            <div class="px-5">

                <h3 class="text-primary">{{ __('Step') }} 4</h3>
                <h5 class="card-title mb-4">{{ __('Insert your Recycle total weight and sell value') }}</h5>

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr class="table-primary">
                                <th>{{ __('Month') }}</th>
                                <th>{{ __('Total Weight') }}</th>
                                <th>{{ __('Total Sell Value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competition->months as $m => $month)
                                <tr>
                                    <td>{{ $month->getName() }}</td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"
                                                id="records_{{ $m }}_value">RM</span>
                                            <input type="number" wire:model='records.{{ $m }}.value'
                                                id="records_{{ $m }}_value"
                                                class="form-control {{ $errors->has('records.' . $m . '.value') ? 'is-invalid' : '' }}"
                                                placeholder="{{ __('Enter your Recycle sell value for') }} {{ $month->getName() }}">
                                        </div>
                                        @error('records.' . $m . '.value')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" wire:model='records.{{ $m }}.weight'
                                                id="records_{{ $m }}_weight"
                                                class="form-control {{ $errors->has('records.' . $m . '.weight') ? 'is-invalid' : '' }}"
                                                placeholder="{{ __('Enter your Recycle total weight for') }} {{ $month->getName() }}">
                                            <span class="input-group-text"
                                                id="records_{{ $m }}_weight">{!! $category_symbol !!}</span>
                                        </div>
                                        @error('records.' . $m . '.weight')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr class="my-4" />
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary-soft" type="button" wire:click='changeTab("water")'>
                        <span wire:loading.remove>{!! __('pagination.previous') !!}</span>
                        <div wire:loading wire:target='changeTab("water")'>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {!! __('pagination.previous') !!}
                        </div>
                    </button>
                    <button class="btn btn-primary" type="button" wire:click='changeTab("used_oil")'>
                        <span wire:loading.remove>{!! __('pagination.next') !!}</span>
                        <div wire:loading wire:target='changeTab("used_oil")'>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {!! __('pagination.next') !!}
                        </div>
                    </button>
                </div>

            </div>
        </div>

        <div class="tab-pane py-xl-10 fade" id="used_oil" role="tabpanel" aria-labelledby="used_oil-tab"
            tabindex="0" wire:ignore.self>
            <div class="px-5">

                <h3 class="text-primary">{{ __('Step') }} 5</h3>
                <h5 class="card-title mb-4">{{ __('Insert your Used Oil total weight and sell value') }}</h5>

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr class="table-primary">
                                <th>{{ __('Month') }}</th>
                                <th>{{ __('Total Weight') }}</th>
                                <th>{{ __('Total Sell Value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competition->months as $m => $month)
                                <tr>
                                    <td>{{ $month->getName() }}</td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"
                                                id="records_{{ $m }}_value">RM</span>
                                            <input type="number" wire:model='records.{{ $m }}.value'
                                                id="records_{{ $m }}_value"
                                                class="form-control {{ $errors->has('records.' . $m . '.value') ? 'is-invalid' : '' }}"
                                                placeholder="{{ __('Enter your Used Oil sell value for') }} {{ $month->getName() }}">
                                        </div>
                                        @error('records.' . $m . '.value')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="number" wire:model='records.{{ $m }}.weight'
                                                id="records_{{ $m }}_weight"
                                                class="form-control {{ $errors->has('records.' . $m . '.weight') ? 'is-invalid' : '' }}"
                                                placeholder="{{ __('Enter your Used Oil total weight for') }} {{ $month->getName() }}">
                                            <span class="input-group-text"
                                                id="records_{{ $m }}_weight">{!! $category_symbol !!}</span>
                                        </div>
                                        @error('records.' . $m . '.weight')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr class="my-4" />
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary-soft" type="button" wire:click='changeTab("recycle")'>
                        <span wire:loading.remove>{!! __('pagination.previous') !!}</span>
                        <div wire:loading wire:target='changeTab("recycle")'>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {!! __('pagination.previous') !!}
                        </div>
                    </button>
                    <button class="btn btn-success" type="button" wire:click='submit'>
                        <span wire:loading.remove>{{ __('Submit') }}</span>
                        <div wire:loading wire:target='submit'>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Submit') }}
                        </div>
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    @laravelTelInputScripts

    <script>
        window.addEventListener('notifyUser', event => {
            if (event.detail.isRetrieved && !event.detail.isSaved) {
                Swal.fire(
                    '{{ __('Information Unavailable') }}',
                    '{{ __('Your Personal Information is unavailable in our database. Please complete your personal details') }}',
                    'error'
                );

                $(".community_phone_number").prop("disabled", false);
                $("[data-phone-input-id=community_phone_number]").val('');
            } else {
                Swal.fire(
                    '{{ __('Information Retrieved') }}',
                    '{{ __('Your Personal Information has been successfully retrieved') }}',
                    'success'
                );

                $(".community_phone_number").prop("disabled", true);
                $("[data-phone-input-id=community_phone_number]").val($("#community_phone_number").val());
            }
        });

        $('#community_identification_number').mask('000000d00d0000', {
            translation: {
                0: {
                    pattern: /[0-9]/
                },
                d: {
                    pattern: /[-]/,
                    fallback: '-'
                }
            }
        });

        window.addEventListener('changeTab', event => {
            const tab = document.getElementById(event.detail.tab + '-tab');
            bootstrap.Tab.getOrCreateInstance(tab).show();
        });
    </script>
@endpush
