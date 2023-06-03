@extends('layouts.guest')

@section('classname', 'app-signup')

@section('title')
    <h2 class="auth-heading text-center mb-5">Sign up to iKalendar</h2>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    {!! htmlScriptTagJsApi() !!}
@endsection

@section('content')
    <div class="auth-form-container text-start mx-auto">
        <!--//auth-form-->
        <form class="auth-form auth-signup-form" method="post" action="{{ route('community.register') }}"
            onsubmit="process(event)" id="communityRegistrationForm">
            @csrf

            @php
                $showAccount = false;
                $showProfile = false;
                $showAddress = false;

                if ($errors->any('profile.*')) {
                    $showProfile = true;
                } elseif ($errors->any('address.*')) {
                    $showAddress = true;
                } else {
                    $showAccount = true;
                }
            @endphp

            <nav>
                <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                    <button class="nav-link {{ $showAccount ? 'active' : '' }}" id="nav-account-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-account" type="button" role="tab" aria-controls="nav-account"
                        aria-selected="{{ $showAccount ? 'true' : 'false' }}">Account
                        {!! $errors->has('account.*') ? '<span class="badge text-bg-danger">!</span>' : '' !!}</button>
                    <button class="nav-link {{ $showProfile ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                        aria-selected="{{ $showProfile ? 'true' : 'false' }}">Profile
                        {!! $errors->has('profile.*') ? '<span class="badge text-bg-danger">!</span>' : '' !!}</button>
                    <button class="nav-link {{ $showAddress ? 'active' : '' }}" id="nav-address-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-address" type="button" role="tab" aria-controls="nav-address"
                        aria-selected="{{ $showAddress ? 'true' : 'false' }}">Address
                        {!! $errors->has('address.*') ? '<span class="badge text-bg-danger">!</span>' : '' !!}</button>
                </div>
            </nav>
            <div class="tab-content pt-3 pb-3" id="nav-tabContent">
                <div class="tab-pane fade {{ $showAccount ? 'show active' : '' }}" id="nav-account" role="tabpanel"
                    aria-labelledby="nav-account-tab" tabindex="0">

                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Username" id="username" name="username" aria-label="username"
                            aria-describedby="username" value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address:</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Email Address" id="email" name="email" aria-label="email"
                            aria-describedby="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Password" id="password" name="password" aria-label="password"
                            aria-describedby="password" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Password Confirmation:</label>
                        <input type="password"
                            class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Password Again" id="password_confirmation" name="password_confirmation"
                            aria-label="password_confirmation" aria-describedby="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="tab-pane fade {{ $showProfile ? 'show active' : '' }}" id="nav-profile" role="tabpanel"
                    aria-labelledby="nav-profile-tab" tabindex="0">

                    <div class="mb-3">
                        <label for="profile.name" class="form-label">Name:</label>
                        <input type="text" class="form-control {{ $errors->has('profile.name') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Name" id="profile.name" name="profile[name]" aria-label="name"
                            oninput="this.value = this.value.toUpperCase()" aria-describedby="name"
                            value="{{ old('profile.name') }}" required>
                        @error('profile.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="profile.identification_number" class="form-label">I/C Number:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('profile.identification_number') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your I/C Number (XXXXXX-XX-XXXX)" id="profile.identification_number"
                            name="profile[identification_number]" aria-label="identification_number"
                            aria-describedby="identification_number" value="{{ old('profile.identification_number') }}"
                            required>
                        <div class="invalid-feedback" id="invalid-ic" style="display: none;">
                            Your I/C Number is NOT valid
                        </div>
                        @error('profile.identification_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="profile.phone_number" class="form-label">Phone Number:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('profile.phone_number') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Phone Number" id="profile.phone_number" name="profile[phone_number]"
                            aria-label="phone_number" aria-describedby="phone_number"
                            value="{{ old('profile.phone_number') }}" required>
                        <div class="invalid-feedback" id="alert-error-phoneNumber" style="display: none;">
                            Your Phone Number in NOT valid
                        </div>
                        @error('profile.phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="tab-pane fade {{ $showAddress ? 'show active' : '' }}" id="nav-address" role="tabpanel"
                    aria-labelledby="nav-address-tab" tabindex="0">

                    <div class="mb-3">
                        <label for="address.address_line_1" class="form-label">Address Line 1:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('address.address_line_1') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Address Line 1" id="address.address_line_1"
                            name="address[address_line_1]" aria-label="address_line_1" aria-describedby="address_line_1"
                            oninput="this.value = this.value.toUpperCase()" value="{{ old('address.address_line_1') }}"
                            required>
                        @error('address.address_line_1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address.address_line_2" class="form-label">Address Line 2:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('address.address_line_2') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Address Line 2" id="address.address_line_2"
                            name="address[address_line_2]" aria-label="address_line_2" aria-describedby="address_line_2"
                            oninput="this.value = this.value.toUpperCase()" value="{{ old('address.address_line_2') }}"
                            required>
                        @error('address.address_line_2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address.address_line_3" class="form-label">Address Line 3:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('address.address_line_3') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Address Line 3" id="address.address_line_3"
                            name="address[address_line_3]" aria-label="address_line_3" aria-describedby="address_line_3"
                            oninput="this.value = this.value.toUpperCase()" value="{{ old('address.address_line_3') }}"
                            required>
                        @error('address.address_line_3')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label for="address.postcode" class="form-label">Postcode:</label>
                            <input type="text"
                                class="form-control {{ $errors->has('address.postcode') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your Postcode" id="address.postcode" name="address[postcode]"
                                aria-label="postcode" aria-describedby="postcode"
                                oninput="this.value = this.value.toUpperCase()" value="{{ old('address.postcode') }}"
                                required>
                            @error('address.postcode')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="address.city" class="form-label">City:</label>
                            <input type="text"
                                class="form-control {{ $errors->has('address.city') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your City" id="address.city" name="address[city]" aria-label="city"
                                aria-describedby="city" oninput="this.value = this.value.toUpperCase()"
                                value="{{ old('address.city') }}" required>
                            @error('address.city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label for="address.state" class="form-label">State:</label>
                            <input type="text"
                                class="form-control {{ $errors->has('address.state') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your State" id="address.state" name="address[state]"
                                aria-label="state" aria-describedby="state"
                                oninput="this.value = this.value.toUpperCase()"
                                value="{{ old('address.state', 'JOHOR') }}" required>
                            @error('address.state')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="address.country" class="form-label">Country:</label>
                            <input type="text"
                                class="form-control {{ $errors->has('address.country') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your Country" id="address.country" name="address[country]"
                                aria-label="country" aria-describedby="country"
                                oninput="this.value = this.value.toUpperCase()"
                                value="{{ old('address.country', 'MALAYSIA') }}" required>
                            @error('address.country')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="pt-3 pb-3">
                <div class="mb-3 d-flex justify-content-center align-items-center">
                    {!! htmlFormSnippet() !!}
                    @error('g-recaptcha-response')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>


            <div class="text-center">
                <button type="submit" id="register" class="btn app-btn-primary w-100 theme-btn mx-auto">Sign
                    Up</button>
            </div>
        </form>
        <div class="auth-option text-center pt-5">Already have an account? <a class="text-link" href="login.html">Log
                in</a>
        </div>
    </div>
    <!--//auth-form-container-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/mykad.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script>
        const identification_numberInput = document.getElementById('profile.identification_number');
        const invalidICDiv = document.getElementById('invalid-ic');

        const phoneInputField = document.getElementById("profile.phone_number");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "my",
            nationalMode: true,
            onlyCountries: ["my"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
        const phoneError = document.querySelector("#alert-error-phoneNumber");

        const registerButton = document.getElementById('register');

        function process(event) {
            event.preventDefault();

            const phoneNumber = phoneInput.getNumber();

            phoneError.style.display = "none";
            invalidICDiv.style.display = "none";

            phoneInputField.classList.remove("is-invalid");
            identification_numberInput.classList.remove("is-invalid");

            if (phoneNumber && !phoneInput.isValidNumber()) {
                phoneError.style.display = "block";
                phoneInputField.classList.add("is-invalid");
            }
            if (!mykad.isValid(identification_numberInput.value)) {
                invalidICDiv.style.display = "block";
                identification_numberInput.classList.add("is-invalid");
            }

            if (phoneNumber && phoneInput.isValidNumber() && mykad.isValid(identification_numberInput.value)) {
                phoneInputField.value = phoneNumber;

                document.getElementById("communityRegistrationForm").submit();
            }
        }
    </script>
@endsection
