@extends('layouts.guest')

@section('apps', 'iKalendar Karbon')

@section('title', __('Reset Password'))

@section('content')
    <div class="col-lg-5">
        <!-- Basic Reset Password form-->
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header justify-content-center">
                <h3 class="fw-light my-4">{{ __('Reset Password') }}</h3>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('Oops!, Something went wrong.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- password confirmation form-->
                <form method="post" action="{{ route('admin.password.confirm') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Form Group (email)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="email">{{ __('Email Address') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email"
                            name="email" type="email" aria-describedby="email"
                            placeholder="{{ __('Enter Your Email Address') }}" required />
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Form Group (password)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="password">{{ __('Password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password"
                            name="password" type="password" aria-describedby="password" aria-describedby="passwordHelpBlock"
                            placeholder="{{ __('Enter Your Password') }}" required />
                        <div id="passwordHelpBlock" class="form-text">
                            {{ __('Your password must be more than 8 characters') }}
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Form Group (password confirmation)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="password_confirmation">{{ __('Password Confirmation') }}</label>
                        <input class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                            id="password_confirmation" name="password_confirmation" type="password"
                            aria-describedby="password_confirmation" placeholder="{{ __('Enter Your Password Again') }}"
                            required />
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Form Group (submit options)-->
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit">{{ __('Reset Password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
