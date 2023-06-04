@extends('layouts.app')

@section('menu')
    <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
        aria-expanded="false"><img
            src="{{ isset(Auth::user()->image) ? route('community.user.picture.show') : asset('assets/images/user.png') }}"
            alt="user profile"></a>
    <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
        <li><a class="dropdown-item" href="{{ route('community.user.profile.view') }}">Profile</a></li>
        <li><a class="dropdown-item" href="{{ route('community.user.setting.view') }}">Settings</a></li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <form action="{{ route('community.logout') }}" method="post">
            @csrf
            <a class="dropdown-item" href="#"
                onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
        </form>
    </ul>
@endsection

@section('sidebar')
    <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
        <ul class="app-menu list-unstyled accordion" id="menu-accordion">
            @include('community.layouts.sidebar.main')
        </ul>
        <!--//app-menu-->
    </nav>
    <!--//app-nav-->

    <div class="app-sidepanel-footer">
        <nav class="app-nav app-nav-footer">
            <ul class="app-menu footer-menu list-unstyled">
                @include('community.layouts.sidebar.footer')
            </ul>
            <!--//footer-menu-->
        </nav>
    </div>
    <!--//app-sidepanel-footer-->
@endsection
