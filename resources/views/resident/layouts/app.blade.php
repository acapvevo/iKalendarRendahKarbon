@extends('layouts.app')

@php
    $home = route('resident.dashboard');
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
@section('picture', Auth::user()->image ? route('resident.user.picture.show') :
    asset('assets/img/illustrations/profiles/profile-1.png'))

@section('topmenu')
    <a class="dropdown-item" href="{{ route('resident.user.profile.view') }}">
        <div class="dropdown-item-icon"><i data-feather="user"></i></div>
        {{ __('Profile') }}
    </a>
    <a class="dropdown-item" href="{{ route('resident.user.setting.view') }}">
        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
        {{ __('Setting') }}
    </a>
    <form action="{{ route('resident.logout') }}" method="post">
        @csrf
        <a class="dropdown-item" href="#!" onclick="event.preventDefault(); this.closest('form').submit();">
            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
            {{ __('Logout') }}
        </a>
    </form>
@endsection

@section('sidemenu')
    <!-- Sidenav Link (Dashboard)-->
    <a class="nav-link" href="{{ route('resident.dashboard') }}">
        <div class="nav-link-icon"><i data-feather="activity"></i></div>
        {{ __('Dashboard') }}
    </a>
    <!-- Sidenav Accordion (Participant Management)-->
    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseParticipant"
        aria-expanded="false" aria-controls="collapseParticipant">
        <div class="nav-link-icon"><i data-feather="users"></i></div>
        {{ __('Participant Management') }}
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseParticipant" data-bs-parent="#participant">
        <nav class="sidenav-menu-nested nav accordion" id="participant">
            <!-- Sidenav Link (Resident)-->
            <a class="nav-link" href="{{ route('resident.participant.community.list') }}">{{ __('Resident') }}</a>
        </nav>
    </div>
    {{-- <a class="nav-link" href="{{ route('resident.contest.competition.list') }}">
        <div class="nav-link-icon"><i class="fa-solid fa-trophy"></i></div>
        {{ __('Competition Submission') }}
    </a> --}}
    {{-- <a class="nav-link" href="{{ route('resident.newsletter.list') }}">
        <div class="nav-link-icon"><i class="fa-regular fa-newspaper"></i></div>
        {{ __('Newsletter') }}
    </a> --}}
@endsection

@push('scripts')
    <script>
        Livewire.onPageExpired((response, message) => {
            window.location.replace("{{ route('resident.login') }}");
        });

        const communityPictureUrl = "{{ route('resident.participant.community.picture', ['community_id' => '']) }}";
    </script>
@endpush
