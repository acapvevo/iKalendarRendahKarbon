@extends('layouts.error')

@yield('apps', 'SB Admin Pro')

@yield('title', '404 Error')

@section('content')
    <div class="col-lg-6">
        <div class="text-center mt-4">
            <img class="img-fluid p-4" src="{{ asset('assets/img/illustrations/404-error-with-a-cute-animal.svg') }}"
                alt="" />
            <p class="lead">This requested URL was not found on this server.</p>
            <a class="text-arrow-icon" href="dashboard-1.html">
                <i class="ms-0 me-1" data-feather="arrow-left"></i>
                Return to Dashboard
            </a>
        </div>
    </div>
@endsection
