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
                <div class="small mb-3 text-muted">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('Oops!, Something went wrong.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- email verification form-->
                <form method="post" action="{{ route('admin.verification.send') }}">
                    @csrf

                    <!-- Form Group (submit options)-->
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit">{{ __('Resend Verification Email') }}</button>
                    </div>
                </form>

                <!-- log out form-->
                <form method="post" action="{{ route('admin.logout') }}">
                    @csrf

                    <!-- Form Group (submit options)-->
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit">{{ __('Log Out') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
