@extends('layouts.guest')

@section('apps', 'iKalendar')

@section('title', __('Registration for') . ' ' . $competition->name)

@section('content')
    <div class="col-lg-12">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header justify-content-center">
                <h3 class="fw-light my-4 text-center">{{ __('Registration for') }} <br> {{ $competition->name }}</h3>
            </div>
            <div class="card-body">
                @livewire('community.contest.form', ['competition' => $competition])
            </div>
        </div>
    </div>
@endsection
