<div>
    <form wire:submit.prevent="update" id="updateUserForm">

        <!-- Profile -->
        <div class="pt-3 pb-3">
            <div class="h4 pb-2 mb-4 text-primary border-bottom border-primary">
                {{ __('Profile') }}
            </div>

            <div class="mb-3 row">
                <div class="col-lg-6 col-12">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control {{ $errors->has('user.name') ? 'is-invalid' : '' }}"
                        id="name" wire:model.lazy="user.name" placeholder="{{ __('Enter Your Name') }}" required
                        oninput="this.value = this.value.toUpperCase()">
                    @error('user.name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-lg-6 col-12">
                    <label for="identification_number" class="form-label">{{ __('Identification Card Number') }}</label>
                    <input type="text"
                        class="form-control {{ $errors->has('user.identification_number') ? 'is-invalid' : '' }}"
                        id="identification_number" wire:model.lazy="user.identification_number"
                        placeholder="{{ __('Enter Your Identification Card Number') }}" required>
                    @error('user.identification_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-lg-6 col-12">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input type="email" class="form-control {{ $errors->has('user.email') ? 'is-invalid' : '' }}"
                        id="email" wire:model.lazy="user.email" placeholder="{{ __('Enter Your Email Address') }}"
                        required>
                    @error('user.email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-lg-6 col-12">
                    <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                    <div wire:ignore>
                        <input type="text"
                            class="form-control {{ $errors->has('user.phone_number') ? 'is-invalid' : '' }}"
                            id="phone_number" wire:model.lazy="user.phone_number"
                            placeholder="{{ __('Enter Your Phone Number') }}" required>
                    </div>
                    @error('user.phone_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Occupation -->
        <div class="pt-3 pb-3">
            <div class="h4 pb-2 mb-4 text-primary border-bottom border-primary">
                {{ __('Occupation') }}
                <small class="text-muted">({{ __('You can ignore this section if you not working') }})</small>
            </div>

            <div class="mb-3">
                <label for="occupation.place" class="form-label">{{ __('Occupation Place') }}:</label>
                <input type="text" class="form-control {{ $errors->has('occupation.place') ? 'is-invalid' : '' }}"
                    placeholder="{{ __('Enter Your Occuaption Place') }}" id="occupation.place"
                    oninput="this.value = this.value.toUpperCase()" wire:model.lazy="occupation.place"
                    aria-label="place" aria-describedby="place">
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
                    oninput="this.value = this.value.toUpperCase()" wire:model.lazy="occupation.position"
                    aria-label="position" aria-describedby="position">
                @error('occupation.position')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="occupation.sector" class="form-label">{{ __('Occupation Sector') }}:</label>
                <select class="form-select {{ $errors->has('occupation.sector') ? 'is-invalid' : '' }}"
                    id="occupation.sector" wire:model="occupation.sector" aria-label="Default select example">
                    <option value="" selected>{{ __('Choose Your Occuaption Sector') }}</option>
                    @foreach (DB::table('occupation_sector_type')->get() as $sector)
                        <option value="{{ $sector->code }}" wire:key="sector-{{ $sector->code }}">
                            {{ strtoupper(__($sector->name)) }}
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

        <!-- Address -->
        <div class="pt-3 pb-3">
            <div class="h4 pb-2 mb-4 text-primary border-bottom border-primary">
                {{ __('Address') }}
            </div>

            <div class="mb-3">
                <label for="address.category" class="form-label">{{ __('Category') }}:</label>
                <select class="form-select {{ $errors->has('address.category') ? 'is-invalid' : '' }}"
                    id="address.category" aria-label="Default select example" wire:model="address.category" required>
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

            <div class="mb-3 row">
                <div class="col-12 col-lg-4">
                    <label for="address.line_1" class="form-label">{{ __('Address Line 1') }}</label>
                    <input type="text" class="form-control {{ $errors->has('address.line_1') ? 'is-invalid' : '' }}"
                        id="address.line_1" wire:model.lazy="address.line_1"
                        placeholder="{{ __('Enter Your Address Line 1') }}" required>
                    @error('address.line_1')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 col-lg-4">
                    <label for="address.line_2" class="form-label">{{ __('Address Line 2') }}</label>
                    <input type="text"
                        class="form-control {{ $errors->has('address.line_2') ? 'is-invalid' : '' }}"
                        id="address.line_2" wire:model.lazy="address.line_2"
                        placeholder="{{ __('Enter Your Address Line 2') }}" required>
                    @error('address.line_2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 col-lg-4">
                    <label for="address.line_3" class="form-label">{{ __('Address Line 3') }}</label>
                    <input type="text"
                        class="form-control {{ $errors->has('address.line_3') ? 'is-invalid' : '' }}"
                        id="address.line_3" wire:model.lazy="address.line_3"
                        placeholder="{{ __('Enter Your Address Line 3') }}">
                    @error('address.line_3')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-12 col-lg-6">
                    <label for="address.postcode" class="form-label">{{ __('Postcode') }}</label>
                    <input type="text"
                        class="form-control {{ $errors->has('address.postcode') ? 'is-invalid' : '' }}"
                        id="address.postcode" wire:model.lazy="address.postcode"
                        placeholder="{{ __('Enter Your Postcode') }}" required>
                    @error('address.postcode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 col-lg-6">
                    <label for="address.city" class="form-label">{{ __('City') }}</label>
                    <input type="text" class="form-control {{ $errors->has('address.city') ? 'is-invalid' : '' }}"
                        id="address.city" wire:model.lazy="address.city" placeholder="{{ __('Enter Your City') }}"
                        required>
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
                        placeholder="{{ __('Enter Your State') }}" readonly required>
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
                        placeholder="{{ __('Enter Your Country') }}" readonly required>
                    @error('address.country')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

    </form>
</div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>

    <script>
        var input = document.getElementById("phone_number");
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
