@extends('layouts.guest')

@section('apps', 'iKalendar Karbon')

@section('title', __('Register As Admin'))

@section('content')
    <div class="col-lg-7">
        <!-- Basic registration form-->
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header justify-content-center">
                <h3 class="fw-light my-4 text-center">{{ __('Create Account As Resident') }}</h3>
            </div>
            <div class="card-body">
                @livewire('admin.auth.register')
            </div>
            <div class="card-footer text-center">
                <div class="small"><a href="{{ route('admin.login') }}">{{ __('Have an account? Go to login') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
