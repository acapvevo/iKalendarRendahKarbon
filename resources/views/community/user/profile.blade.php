@extends('community.layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
@endsection

@section('title')
    <h1 class="app-page-title">User Profile</h1>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">User</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="pt-3 pb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                    Update
                </button>
            </div>
            <div class="table-repsonsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="w-25">Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">Identification Card (I/C) No.</th>
                            <td>{{ $user->identification_number }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">Phone Number</th>
                            <td>{{ $user->phone_number }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">Address</th>
                            <td>{{ $user->address->line_1 }}, <br>
                                {{ $user->address->line_2 }}, <br>
                                {!! $user->address->line_3 ? $user->address->line_3 . ', <br>' : '' !!}
                                {{ $user->address->postcode }} {{ $user->address->city }}, <br>
                                {{ $user->address->state }}, {{ $user->address->country }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateUserModalLabel">Update User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @livewire('community.user.profile', ['user' => $user])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick='$("#updateUserForm").trigger("reset");'
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="updateUserForm">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/mykad.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script>
        const identification_numberInput = document.getElementById('identification_number');
        const invalidICDiv = document.getElementById('invalid-ic');

        const phoneInputField = document.getElementById("phone_number");
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

                document.getElementById("updateUserForm").submit();
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
    @if ($errors->any())
        <script>
            showModalOnError('updateUserModal')
        </script>
    @endif
@endsection
