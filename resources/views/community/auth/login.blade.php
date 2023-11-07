@extends('layouts.guest')

@section('apps', 'iKalendar Karbon')

@section('title', __('Login As Resident'))

@section('content')
    <div class="col-lg-5">
        <!-- Basic login form-->
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header justify-content-center">
                <h3 class="fw-light my-4 text-center">{{ __('Login As Resident') }}</h3>
            </div>
            <div class="card-body">
                <!-- Login form-->
                <form class="auth-form login-form" action="{{ route('community.login') }}" method="post">
                    @csrf

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

                    <!-- Form Group (Username)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="username">{{ __('Username') }}</label>
                        <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('Enter Your Username') }}" id="username" name="username"
                            aria-label="Username" aria-describedby="username" value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Form Group (password)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="password">{{ __('Password') }}</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('Enter Your Password') }}" id="password" name="password"
                            aria-label="password" aria-describedby="password" value="{{ old('password') }}">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Form Group (remember password checkbox)-->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" id="remember" name="remember" type="checkbox" />
                            <label class="form-check-label" for="remember">{{ __('Remember password') }}</label>
                        </div>
                    </div>

                    <!-- Form Group (login box)-->
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="{{ route('community.password.request') }}">{{ __('Forgot Password?') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <div class="small"><a href="{{ route('community.register') }}">{{ __('Need an account? Sign up!') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
