@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

<div>
    <form class="auth-form auth-signup-form" wire:submit.prevent="create" id="communityRegistrationForm">
        <ul class="nav nav-pills nav-justified" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account-tab-pane"
                    type="button" role="tab" aria-controls="account-tab-pane" wire:ignore
                    aria-selected="true">{{ __('Account') }}
                </button>
                {!! $errors->has('user.username') || $errors->has('user.email') || $errors->has('password')
                    ? '<span class="badge text-bg-danger">!</span>'
                    : '' !!}
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane" wire:ignore
                    aria-selected="false">{{ __('Profile') }}</button>
                {!! $errors->has('user.name') || $errors->has('user.identification_number') || $errors->has('user.phone_number')
                    ? '<span class="badge text-bg-danger">!</span>'
                    : '' !!}
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="occupation-tab" data-bs-toggle="tab" data-bs-target="#occupation-tab-pane"
                    type="button" role="tab" aria-controls="occupation-tab-pane" wire:ignore
                    aria-selected="false">{{ __('Occupation') }}</button>
                {!! $errors->has('occupation.*') ? '<span class="badge text-bg-danger">!</span>' : '' !!}
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address-tab-pane"
                    type="button" role="tab" aria-controls="address-tab-pane" wire:ignore
                    aria-selected="false">{{ __('Address') }}</button>
                {!! $errors->has('address.*') ? '<span class="badge text-bg-danger">!</span>' : '' !!}
            </li>
        </ul>
        <div class="tab-content pt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="account-tab-pane" role="tabpanel" aria-labelledby="account-tab"
                tabindex="0" wire:ignore.self>

                <div class="mb-3">
                    <label for="user.username" class="form-label">{{ __('Username') }}:</label>
                    <input type="text" class="form-control {{ $errors->has('user.username') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Username') }}" id="user.username" aria-label="username"
                        aria-describedby="username" wire:model.lazy="user.username" required>
                    @error('user.username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="user.email" class="form-label">{{ __('Email Address') }}:</label>
                    <input type="email" class="form-control {{ $errors->has('user.email') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Email Address') }}" id="user.email" aria-label="email"
                        aria-describedby="email" wire:model.lazy="user.email" required>
                    @error('user.email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}:</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Password') }}" id="password" aria-label="password"
                        aria-describedby="password" wire:model.lazy="password" required>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Password Confirmation') }}:</label>
                    <input type="password"
                        class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Password Again') }}" id="password_confirmation"
                        aria-label="password_confirmation" aria-describedby="password_confirmation"
                        wire:model.lazy="password_confirmation" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                tabindex="0" wire:ignore.self>

                <div class="mb-3">
                    <label for="user.name" class="form-label">{{ __('Name') }}:</label>
                    <input type="text" class="form-control {{ $errors->has('user.name') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Name') }}" id="user.name" aria-label="name"
                        oninput="this.value = this.value.toUpperCase()" aria-describedby="name"
                        wire:model.lazy="user.name" required>
                    @error('user.name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="user.identification_number"
                        class="form-label">{{ __('Identification Card Number') }}:</label>
                    <input type="text"
                        class="form-control {{ $errors->has('user.identification_number') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Identification Card Number') }} (XXXXXX-XX-XXXX)"
                        id="user.identification_number" aria-label="identification_number"
                        aria-describedby="identification_number" wire:model.lazy="user.identification_number"
                        required>
                    <div class="invalid-feedback" id="invalid-ic" style="display: none;">
                        {{ __('Your Identification Card Number is NOT valid') }}
                    </div>
                    @error('user.identification_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="user.phone_number" class="form-label">{{ __('Phone Number') }}:</label>
                    <div wire:ignore>
                        <input type="text"
                            class="form-control {{ $errors->has('user.phone_number') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('Enter Your Phone Number') }}" id="user.phone_number"
                            aria-label="phone_number" aria-describedby="phone_number"
                            wire:model.lazy="user.phone_number" required>
                    </div>
                    @error('user.phone_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>
            <div class="tab-pane fade" id="occupation-tab-pane" role="tabpanel" aria-labelledby="occupation-tab"
                tabindex="0" wire:ignore.self>

                <div class="pb-3">
                    <small class="text-muted">({{ __('You can ignore this section if you not working') }})</small>
                </div>

                <div class="mb-3">
                    <label for="occupation.place" class="form-label">{{ __('Occupation Place') }}:</label>
                    <input type="text"
                        class="form-control {{ $errors->has('occupation.place') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Occuaption Place') }}" id="occupation.place"
                        aria-label="place" aria-describedby="place" wire:model.lazy="occupation.place">
                    @error('occupation.place')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="occupation.position" class="form-label">{{ __('Occupation Position') }}:</label>
                    <input type="text"
                        class="form-control {{ $errors->has('occupation.position') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Occuaption Position') }}" id="occupation.position"
                        aria-label="position" aria-describedby="position" wire:model.lazy="occupation.position">
                    @error('occupation.position')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="occupation.sector" class="form-label">{{ __('Occupation Sector') }}:</label>
                    <select class="form-select {{ $errors->has('occupation.sector') ? 'is-invalid' : '' }}"
                        id="occupation.sector" aria-label="Default select example" wire:model="occupation.sector">
                        <option value="" selected>{{ __('Choose Your Occuaption Sector') }}</option>
                        @foreach (DB::table('occupation_sector_type')->get() as $sector)
                            <option value="{{ $sector->code }}" wire:key="sector-{{ $sector->code }}">
                                {{ __($sector->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('occupation.sector')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="tab-pane fade" id="address-tab-pane" role="tabpanel" aria-labelledby="address-tab"
                tabindex="0" wire:ignore.self>

                <div class="mb-3">
                    <label for="address.category" class="form-label">{{ __('Category') }}:</label>
                    <select class="form-select {{ $errors->has('address.category') ? 'is-invalid' : '' }}"
                        id="address.category" aria-label="Default select example" wire:model="address.category"
                        required>
                        <option selected value="">{{ __('Choose Address Category') }}</option>
                        @foreach (DB::table('address_category')->get() as $category)
                            <option value="{{ $category->code }}" wire:key="category-{{ $category->code }}">
                                {{ __($category->name) }}
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
                    <label for="address.line_1" class="form-label">{{ __('Address Line 1') }}:</label>
                    <input type="text"
                        class="form-control {{ $errors->has('address.line_1') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Address Line 1') }}" id="address.line_1" aria-label="line_1"
                        aria-describedby="line_1" oninput="this.value = this.value.toUpperCase()"
                        wire:model.lazy="address.line_1" required>
                    @error('address.line_1')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address.line_2" class="form-label">{{ __('Address Line 2') }}:</label>
                    <input type="text"
                        class="form-control {{ $errors->has('address.line_2') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Address Line 2') }}" id="address.line_2" aria-label="line_2"
                        aria-describedby="line_2" oninput="this.value = this.value.toUpperCase()"
                        wire:model.lazy="address.line_2" required>
                    @error('address.line_2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address.line_3" class="form-label">{{ __('Address Line 3') }}:</label>
                    <input type="text"
                        class="form-control {{ $errors->has('address.line_3') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Address Line 3') }}" id="address.line_3" aria-label="line_3"
                        aria-describedby="line_3" oninput="this.value = this.value.toUpperCase()"
                        wire:model.lazy="address.line_3">
                    @error('address.line_3')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 row">
                    <div class="col-12 col-lg-6">
                        <label for="address.postcode" class="form-label">{{ __('Postcode') }}:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('address.postcode') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('Enter Your Postcode') }}" id="address.postcode"
                            aria-label="postcode" aria-describedby="postcode"
                            oninput="this.value = this.value.toUpperCase()" wire:model.lazy="address.postcode"
                            required>
                        @error('address.postcode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="address.city" class="form-label">{{ __('City') }}:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('address.city') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('Enter Your City') }}" id="address.city" aria-label="city"
                            aria-describedby="city" oninput="this.value = this.value.toUpperCase()"
                            wire:model.lazy="address.city" required>
                        @error('address.city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-12 col-lg-6">
                        <label for="address.state" class="form-label">{{ __('State') }}:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('address.state') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('Enter Your State') }}" id="address.state" aria-label="state"
                            aria-describedby="state" oninput="this.value = this.value.toUpperCase()"
                            wire:model.lazy="address.state" readonly required>
                        @error('address.state')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="address.country" class="form-label">{{ __('Country') }}:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('address.country') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('Enter Your Country') }}" id="address.country" aria-label="country"
                            aria-describedby="country" oninput="this.value = this.value.toUpperCase()"
                            wire:model.lazy="address.country" readonly required>
                        @error('address.country')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-3 d-flex justify-content-center align-items-center">
            <div wire:ignore>
                {!! htmlScriptTagJsApi() !!}
                {!! htmlFormSnippet([
                    'callback' => 'onCallback',
                ]) !!}
            </div>
            @error('captcha')
                <br>
                <div class="invalid-feedback" style="display: block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Form Group (create account submit)-->
        <div class="pt-3 pb-3 d-flex justify-content-center align-items-center">
            <button class="btn btn-primary btn-block" type="submit">{{ __('Create Account') }}</button>
        </div>
    </form>
</div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>

    <script>
        var input = document.getElementById("user.phone_number");
        window.intlTelInput(input, {
            onlyCountries: ['my'],
            initialCountry: 'my',
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
        });

        $('#user.identification_number').mask('000000-00-0000', {
            'translation': {
                0: {
                    pattern: /[0-9]/
                }
            }
        });
    </script>
@endsection

@push('scripts')
    <script>
        var onCallback = function() {
            @this.set('captcha', grecaptcha.getResponse());
        }
    </script>
@endpush
