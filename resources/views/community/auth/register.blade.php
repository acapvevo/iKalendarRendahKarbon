@extends('layouts.guest')

@section('apps', 'iKalendar Karbon')

@section('title', 'Login As Community')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    {!! htmlScriptTagJsApi() !!}
@endsection

@section('content')
    <div class="col-lg-7">
        <!-- Basic registration form-->
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header justify-content-center">
                <h3 class="fw-light my-4 text-center">Create Account As Community</h3>
            </div>
            <div class="card-body">
                <!-- Registration form-->
                <form class="auth-form auth-signup-form" method="post" action="{{ route('community.register') }}"
                    onsubmit="process(event)" id="communityRegistrationForm">
                    @csrf

                    <div class="pt-3 pb-3">
                        <hr>
                        <h5 class="text-center">Account</h5>
                        <hr>
                    </div>

                    <!--Account-->
                    <div class="mb-3 row">
                        <div class="col-12 col-lg-6">
                            <label for="account.username" class="form-label">Username:</label>
                            <input type="text"
                                class="form-control {{ $errors->has('account.username') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your Username" id="account.username" name="account[username]"
                                aria-label="username" aria-describedby="username" value="{{ old('account.username') }}"
                                required>
                            @error('account.username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="account.email" class="form-label">Email Address:</label>
                            <input type="email"
                                class="form-control {{ $errors->has('account.email') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your Email Address" id="account.email" name="account[email]"
                                aria-label="email" aria-describedby="email" value="{{ old('account.email') }}" required>
                            @error('account.email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-12 col-lg-6">
                            <label for="account.password" class="form-label">Password:</label>
                            <input type="password"
                                class="form-control {{ $errors->has('account.password') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your Password" id="account.password" name="account[password]"
                                aria-label="password" aria-describedby="password" required>
                            @error('account.password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="account.password_confirmation" class="form-label">Password Confirmation:</label>
                            <input type="password"
                                class="form-control {{ $errors->has('account.password_confirmation') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your Password Again" id="account.password_confirmation"
                                name="account[password_confirmation]" aria-label="password_confirmation"
                                aria-describedby="password_confirmation" required>
                            @error('account.password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-3 pb-3">
                        <hr>
                        <h5 class="text-center">Profile</h5>
                        <hr>
                    </div>

                    <!--Profile-->
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

                    <div class="mb-3 row">
                        <div class="col-12 col-lg-6">
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
                        <div class="col-12 col-lg-6">
                            <label for="profile.phone_number" class="form-label">Phone Number:</label>
                            <input type="text"
                                class="form-control {{ $errors->has('profile.phone_number') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your Phone Number" id="profile.phone_number"
                                name="profile[phone_number]" aria-label="phone_number" aria-describedby="phone_number"
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

                    <div class="pt-3 pb-3">
                        <hr>
                        <h5 class="text-center">Address</h5>
                        <hr>
                    </div>

                    <!--Address-->
                    <div class="mb-3">
                        <label for="address.line_1" class="form-label">Address Line 1:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('address.line_1') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Address Line 1" id="address.line_1" name="address[line_1]"
                            aria-label="line_1" aria-describedby="line_1" oninput="this.value = this.value.toUpperCase()"
                            value="{{ old('address.line_1') }}" required>
                        @error('address.line_1')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address.line_2" class="form-label">Address Line 2:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('address.line_2') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Address Line 2" id="address.line_2" name="address[line_2]"
                            aria-label="line_2" aria-describedby="line_2" oninput="this.value = this.value.toUpperCase()"
                            value="{{ old('address.line_2') }}" required>
                        @error('address.line_2')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address.line_3" class="form-label">Address Line 3:</label>
                        <input type="text"
                            class="form-control {{ $errors->has('address.line_3') ? 'is-invalid' : '' }}"
                            placeholder="Enter Your Address Line 3" id="address.line_3" name="address[line_3]"
                            aria-label="line_3" aria-describedby="line_3" oninput="this.value = this.value.toUpperCase()"
                            value="{{ old('address.line_3') }}">
                        @error('address.line_3')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <div class="col-12 col-lg-6">
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
                        <div class="col-12 col-lg-6">
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
                        <div class="col-12 col-lg-6">
                            <label for="address.state" class="form-label">State:</label>
                            <input type="text"
                                class="form-control {{ $errors->has('address.state') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your State" id="address.state" name="address[state]"
                                aria-label="state" aria-describedby="state"
                                oninput="this.value = this.value.toUpperCase()"
                                value="{{ old('address.state', 'JOHOR') }}" readonly required>
                            @error('address.state')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="address.country" class="form-label">Country:</label>
                            <input type="text"
                                class="form-control {{ $errors->has('address.country') ? 'is-invalid' : '' }}"
                                placeholder="Enter Your Country" id="address.country" name="address[country]"
                                aria-label="country" aria-describedby="country"
                                oninput="this.value = this.value.toUpperCase()"
                                value="{{ old('address.country', 'MALAYSIA') }}" readonly required>
                            @error('address.country')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-3 pb-3 d-flex justify-content-center align-items-center">
                        {!! htmlFormSnippet() !!}
                        @error('g-recaptcha-response')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Form Group (create account submit)-->
                    <div class="pt-3 pb-3 d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary btn-block" type="submit">Create Account</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <div class="small"><a href="{{ route('community.login') }}">Have an account? Go to login</a></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/mykad.min.js') }}"></script>
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

        $('#identification_number').mask('000000-00-0000', {
            'translation': {
                0: {
                    pattern: /[0-9]/
                }
            }
        });
    </script>
@endsection
