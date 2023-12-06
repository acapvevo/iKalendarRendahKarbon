@extends('layouts.app')

@php
    $home = route('community.dashboard');
@endphp

@section('alerts')
    <!-- Example Alert 1-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <div class="dropdown-notifications-item-icon bg-warning"><i data-feather="activity"></i></div>
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-details">December 29, 2021</div>
            <div class="dropdown-notifications-item-content-text">This is an alert message. It's
                nothing serious, but it requires your attention.</div>
        </div>
    </a>
    <!-- Example Alert 2-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <div class="dropdown-notifications-item-icon bg-info"><i data-feather="bar-chart"></i></div>
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-details">December 22, 2021</div>
            <div class="dropdown-notifications-item-content-text">A new monthly report is ready. Click
                here to view!</div>
        </div>
    </a>
    <!-- Example Alert 3-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <div class="dropdown-notifications-item-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-details">December 8, 2021</div>
            <div class="dropdown-notifications-item-content-text">Critical system failure, systems
                shutting down.</div>
        </div>
    </a>
    <!-- Example Alert 4-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <div class="dropdown-notifications-item-icon bg-success"><i data-feather="user-plus"></i>
        </div>
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-details">December 2, 2021</div>
            <div class="dropdown-notifications-item-content-text">New user request. Woody has requested
                access to the organization.</div>
        </div>
    </a>
@endsection

@section('messages')
    <!-- Example Message 1  -->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-2.png') }}" />
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet,
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
            <div class="dropdown-notifications-item-content-details">Thomas Wilcox · 58m</div>
        </div>
    </a>
    <!-- Example Message 2-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-3.png') }}" />
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet,
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
            <div class="dropdown-notifications-item-content-details">Emily Fowler · 2d</div>
        </div>
    </a>
    <!-- Example Message 3-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-4.png') }}" />
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet,
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
            <div class="dropdown-notifications-item-content-details">Marshall Rosencrantz · 3d</div>
        </div>
    </a>
    <!-- Example Message 4-->
    <a class="dropdown-item dropdown-notifications-item" href="#!">
        <img class="dropdown-notifications-item-img" src="{{ asset('assets/img/illustrations/profiles/profile-5.png') }}" />
        <div class="dropdown-notifications-item-content">
            <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet,
                consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
            <div class="dropdown-notifications-item-content-details">Colby Newton · 3d</div>
        </div>
    </a>
@endsection

@section('name', Auth::user()->name ?? Auth::user()->username)
@section('email', Auth::user()->email)
@section('picture', Auth::user()->image ? route('community.user.picture.show') :
    asset('assets/img/illustrations/profiles/profile-1.png'))

@section('topmenu')
    <a class="dropdown-item" href="{{ route('community.user.profile.view') }}">
        <div class="dropdown-item-icon"><i data-feather="user"></i></div>
        {{ __('Profile') }}
    </a>
    <a class="dropdown-item" href="{{ route('community.user.finance.view') }}">
        <div class="dropdown-item-icon"><i data-feather="dollar-sign"></i></div>
        {{ __('Finance Information') }}
    </a>
    <a class="dropdown-item" href="{{ route('community.user.setting.view') }}">
        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
        {{ __('Setting') }}
    </a>
    <form action="{{ route('community.logout') }}" method="post">
        @csrf
        <a class="dropdown-item" href="#!" onclick="event.preventDefault(); this.closest('form').submit();">
            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
            {{ __('Logout') }}
        </a>
    </form>
@endsection

@section('sidemenu')
    <!-- Sidenav Link (Dashboard)-->
    <a class="nav-link" href="{{ route('community.dashboard') }}">
        <div class="nav-link-icon"><i data-feather="activity"></i></div>
        {{ __('Dashboard') }}
    </a>
    <a class="nav-link" href="{{ route('community.contest.competition.list') }}">
        <div class="nav-link-icon"><i class="fa-solid fa-trophy"></i></div>
        {{ __('Competition Submission') }}
    </a>
    <a class="nav-link" href="{{ route('community.newsletter.list') }}">
        <div class="nav-link-icon"><i class="fa-regular fa-newspaper"></i></div>
        {{ __('Newsletter') }}
    </a>
@endsection

@push('scripts')
    <script>
        @if ((url()->current() != route('community.user.profile.view')) &&
                !request()->user()->checkCompletion())
            Swal.fire({
                title: "{{ __('Profile Incomplete') }}",
                text: "{{ __('Your Profile is Incomplete. Please Complete your Profile') }}",
                icon: 'warning',
                confirmButtonText: "{{ __('Go to Profile Page') }}",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace("{{ route('community.user.profile.view') }}");
                }
            })
        @endif

        Livewire.onPageExpired((response, message) => {
            window.location.replace("{{ route('community.login') }}");
        })
    </script>
@endpush
