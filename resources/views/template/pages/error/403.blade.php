@extends('layouts.error')

@yield('apps', 'SB Admin Pro')

@yield('title', '403 Error')

@section('content')
    <div class="col-lg-6">
        <div class="text-center mt-4">
            <img class="img-fluid p-4" src="{{ asset('assets/img/illustrations/403-error-forbidden.svg') }}" alt="" />
            <p class="lead">Your client does not have permission to get this page from the server.</p>
            <a class="text-arrow-icon" href="dashboard-1.html">
                <i class="ms-0 me-1" data-feather="arrow-left"></i>
                Return to Dashboard
            </a>
        </div>
    </div>
@endsection
