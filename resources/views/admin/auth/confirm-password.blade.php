@extends('layouts.guest')

@section('apps', 'iKalendar Karbon')

@section('title', __('Password Confirmation'))

@section('content')
    <div class="col-lg-5">
        <!-- Basic forgot password form-->
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header justify-content-center">
                <h3 class="fw-light my-4">{{ __('Password Confirmation') }}</h3>
            </div>
            <div class="card-body">
                <div class="small mb-3 text-muted">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('Oops!, Something went wrong.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- password confirmation form-->
                <form method="post" action="{{ route('admin.password.confirm') }}">
                    @csrf

                    <!-- Form Group (password)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="password">{{ __('Password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password"
                            name="password" type="password" aria-describedby="password"
                            placeholder="{{ __('Enter Your Password') }}" required />
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Form Group (submit options)-->
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit">{{ __('Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
