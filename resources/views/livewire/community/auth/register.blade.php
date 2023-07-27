@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

    <style>
        /* .tab-content {
                        display: flex;
                    }

                    .tab-content>.tab-pane {
                        display: block;
                        /* undo "display: none;" */
        visibility: hidden;
        margin-right: -100%;
        width: 100%;
        }

        .tab-content>.active {
            visibility: visible;
        }

        */
    </style>
@endsection

<div>
    <form class="auth-form auth-signup-form" wire:submit.prevent="create" id="communityRegistrationForm">
        <ul class="nav nav-pills nav-justified" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="wizard1-tab" data-bs-toggle="tab" data-bs-target="#wizard1-tab-pane"
                    type="button" role="tab" aria-controls="wizard1-tab-pane" wire:ignore.self aria-selected="true"
                    wire:click.prevent="setTab(1)">
                    <div>
                        {{ __('Account') }}
                        {!! $errors->has('user.username') || $errors->has('user.email') || $errors->has('password')
                            ? '<span class="badge text-bg-danger">!</span>'
                            : '' !!}
                    </div>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="wizard2-tab" data-bs-toggle="tab" data-bs-target="#wizard2-tab-pane"
                    type="button" role="tab" aria-controls="wizard2-tab-pane" wire:ignore.self
                    aria-selected="false" wire:click.prevent="setTab(2)">
                    <div>
                        {{ __('Profile') }}
                        {!! $errors->has('user.name') || $errors->has('user.identification_number') || $errors->has('user.phone_number')
                            ? '<span class="badge text-bg-danger">!</span>'
                            : '' !!}</div>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="wizard3-tab" data-bs-toggle="tab" data-bs-target="#wizard3-tab-pane"
                    type="button" role="tab" aria-controls="wizard3-tab-pane" wire:ignore.self
                    aria-selected="false" wire:click.prevent="setTab(3)">
                    <div>
                        {{ __('Occupation') }}
                        {!! $errors->has('occupation.*') ? '<span class="badge text-bg-danger">!</span>' : '' !!}
                    </div>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="wizard4-tab" data-bs-toggle="tab" data-bs-target="#wizard4-tab-pane"
                    type="button" role="tab" aria-controls="wizard4-tab-pane" wire:ignore.self
                    aria-selected="false" wire:click.prevent="setTab(4)">
                    <div>
                        {{ __('Address') }}
                        {!! $errors->has('address.*') ? '<span class="badge text-bg-danger">!</span>' : '' !!}
                    </div>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="wizard5-tab" data-bs-toggle="tab" data-bs-target="#wizard5-tab-pane"
                    type="button" role="tab" aria-controls="wizard5-tab-pane" wire:ignore.self
                    aria-selected="false" wire:click.prevent="setTab(5)">
                    <div>
                        {{ __('Confirmation') }}
                    </div>
                </button>
            </li>
        </ul>
        <div class="tab-content pt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="wizard1-tab-pane" role="tabpanel" aria-labelledby="wizard1-tab"
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
            <div class="tab-pane fade" id="wizard2-tab-pane" role="tabpanel" aria-labelledby="wizard2-tab"
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
            <div class="tab-pane fade" id="wizard3-tab-pane" role="tabpanel" aria-labelledby="wizard3-tab"
                tabindex="0" wire:ignore.self>

                <div class="pb-3">
                    <small class="text-muted">({{ __('You can ignore this section if you not working') }})</small>
                </div>

                <div class="mb-3">
                    <label for="occupation.place" class="form-label">{{ __('Place') }}:</label>
                    <input type="text"
                        class="form-control {{ $errors->has('occupation.place') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Occuaption Place') }}" id="occupation.place"
                        aria-label="place" aria-describedby="place" oninput="this.value = this.value.toUpperCase()"
                        wire:model.lazy="occupation.place">
                    @error('occupation.place')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="occupation.position" class="form-label">{{ __('Position') }}:</label>
                    <input type="text"
                        class="form-control {{ $errors->has('occupation.position') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Enter Your Occuaption Position') }}" id="occupation.position"
                        aria-label="position" aria-describedby="position"
                        oninput="this.value = this.value.toUpperCase()" wire:model.lazy="occupation.position">
                    @error('occupation.position')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="occupation.sector" class="form-label">{{ __('Sector') }}:</label>
                    <select class="form-select {{ $errors->has('occupation.sector') ? 'is-invalid' : '' }}"
                        id="occupation.sector" aria-label="Default select example" wire:model="occupation.sector">
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
            <div class="tab-pane fade" id="wizard4-tab-pane" role="tabpanel" aria-labelledby="wizard4-tab"
                tabindex="0" wire:ignore.self>

                <div class="mb-3">
                    <label for="address.category" class="form-label">{{ __('Category') }}:</label>
                    <select class="form-select {{ $errors->has('address.category') ? 'is-invalid' : '' }}"
                        id="address.category" aria-label="Default select example" wire:model="address.category"
                        required>
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
            <div class="tab-pane fade" id="wizard5-tab-pane" role="tabpanel" aria-labelledby="wizard5-tab"
                tabindex="0" wire:ignore.self>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="4" class="text-center">{{ __('Account') }}</th>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Username') }}</th>
                            <td colspan="3">{{ $user->username ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Email Address') }}</th>
                            <td colspan="3">{{ $user->email ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Password') }}</th>
                            <td colspan="3">
                                <div class="row row-cols-lg-auto g-2 align-items-center">

                                    <div class="col-12">
                                        <input type="password" readonly class="form-control-plaintext"
                                            id="password_preview" value="{{ $password ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-outline-secondary btn-sm float-end"
                                            id="password_preview_btn" wire:click.prevent="toogleVisibility"><i
                                                class="fa-regular fa-eye"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-center">{{ __('Profile') }}</th>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Name') }}</th>
                            <td colspan="3">{{ $user->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Identification Card Number') }}</th>
                            <td colspan="3">{{ $user->identification_number ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Phone Number') }}</th>
                            <td colspan="3">{{ $user->phone_number ? '+6' . $user->phone_number : '' }}</td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-center">{{ __('Occupation') }}</th>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Place') }}</th>
                            <td colspan="3">{{ $occupation->place ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Position') }}</th>
                            <td colspan="3">{{ $occupation->position ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Sector') }}</th>
                            <td colspan="3">
                                {{ $occupation->sector ? strtoupper(__($occupation->getSector()->name)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-center">{{ __('Address') }}</th>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Category') }}</th>
                            <td colspan="3">
                                {{ $address->category ? strtoupper(__($address->getCategory()->name)) : '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Address Line 1') }}</th>
                            <td colspan="3">{{ $address->line_1 ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Address Line 2') }}</th>
                            <td colspan="3">{{ $address->line_2 ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Address Line 3') }}</th>
                            <td colspan="3">{{ $address->line_3 ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('City') }}</th>
                            <td>{{ $address->city ?? '' }}</td>
                            <th class="w-25">{{ __('Postcode') }}</th>
                            <td>{{ $address->postcode ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('State') }}</th>
                            <td>{{ $address->state }}</td>
                            <th class="w-25">{{ __('Country') }}</th>
                            <td>{{ $address->country }}</td>
                        </tr>
                    </table>
                </div>

                <div class="mb-3 d-flex justify-content-center align-items-center">
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
            </div>
        </div>

        <!-- Form Group (create account submit)-->
        <div class="pt-3 pb-3 d-flex justify-content-center align-items-center">
            @if ($tab_state != 1)
                <button class="btn btn-danger btn-block" type="button" wire:click.prevent="previousTab">
                    {!! __('pagination.previous') !!}
                </button>
            @endif
            <div class="mx-3">
                @if ($tab_state == 5)
                    <button class="btn btn-primary btn-block" type="submit" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ __('Create Account') }}</span>
                        <div wire:loading wire:target="create">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Creating Account...') }}
                        </div>
                    </button>
                @else
                    <button class="btn btn-success btn-block" type="button" wire:click.prevent="nextTab">
                        {!! __('pagination.next') !!}
                    </button>
                @endif
            </div>
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

        Livewire.on('changeTab', tab_state => {
            const wizardTab = document.getElementById('wizard' + tab_state + '-tab');
            bootstrap.Tab.getOrCreateInstance(wizardTab).show();
        })

        Livewire.on('tooglePasswordVisibility', isVisible => {
            const password_preview = document.getElementById('password_preview');
            const password_preview_btn = document.getElementById('password_preview_btn');

            if (isVisible) {
                password_preview.type = 'text';
                password_preview_btn.innerHtml = '<i class="fa-regular fa-eye-slash"></i>';

            } else {
                password_preview.type = 'password';
                password_preview_btn.innerHtml = '<i class="fa-regular fa-eye"></i>';
            }
        })
    </script>
@endpush
