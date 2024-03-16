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
                @if ($competition->checkCurrentCompetitionDuration())
                    @livewire('community.contest.form', ['competition' => $competition])
                @else
                    <div class="py-5 d-flex justify-content-center">
                        <i class="fa-solid fa-circle-minus fa-10x text-danger"></i>
                    </div>
                    <h5 class="card-title text-center">{{ __('Registration Closed') }}</h5>
                    <p class="py-3 card-text text-center">
                        {{ __('The registration for this competition has been closed. See you next year') }}
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
