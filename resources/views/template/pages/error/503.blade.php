@extends('layouts.error')

@yield('apps', 'SB Admin Pro')

@yield('title', '503 Error')

@section('content')
    <div class="col-lg-6">
        <div class="text-center mt-4">
            <img class="img-fluid p-4" src="{{ asset('assets/img/illustrations/503-error-service-unavailable.svg') }}"
                alt="" />
            <p class="lead">The server is temporarily unable to service your request due to maintenance downtime or
                capacity problems. Please try again later.</p>
            <a class="text-arrow-icon" href="dashboard-1.html">
                <i class="ms-0 me-1" data-feather="arrow-left"></i>
                Return to Dashboard
            </a>
        </div>
    </div>
@endsection
