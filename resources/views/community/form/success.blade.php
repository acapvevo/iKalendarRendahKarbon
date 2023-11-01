@extends('layouts.guest')

@section('apps', 'iKalendar')

@section('title', __('Registration Success'))

@section('content')
    <div class="col-lg-12">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-body">
                <div class="py-5 d-flex justify-content-center">
                    <i class="fa-solid fa-circle-check fa-bounce fa-10x text-success"></i>
                </div>
                <h5 class="card-title text-center">{{ __('Registration Success') }}</h5>
                <p class="py-3 card-text text-center">
                    {{ __('Your Registration has been successfully submitted. You can log in to our system by using the username and password through this') }}
                    <a href="{{ route('community.login') }}">{{ __('link') }}</a>
                </p>
            </div>
        </div>
    </div>
@endsection
