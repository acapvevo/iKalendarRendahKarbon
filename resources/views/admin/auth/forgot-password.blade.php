@extends('layouts.guest')

@section('apps', 'iKalendar Karbon')

@section('title', __('Password Recovery'))

@section('content')
    <div class="col-lg-5">
        <!-- Basic forgot password form-->
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header justify-content-center">
                <h3 class="fw-light my-4">{{ __('Password Recovery') }}</h3>
            </div>
            <div class="card-body">
                <div class="small mb-3 text-muted">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('Oops!, Something went wrong.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Forgot password form-->
                <form method="post" action="{{ route('admin.password.email') }}">
                    @csrf

                    <!-- Form Group (email address)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="email">{{ __('Email Address') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email"
                            name="email" type="email" aria-describedby="emailHelp" value="{{ old('email') }}"
                            placeholder="{{ __('Enter Your Email Address') }}" required />
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Form Group (submit options)-->
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="{{ route('admin.login') }}">{{ __('Return to login') }}</a>
                        <button class="btn btn-primary" type="submit">{{ __('Reset Password') }}</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <div class="small"><a href="{{ route('admin.register') }}">{{ __('Need an account? Sign up!') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
