@extends('community.layouts.app')

@section('title')
    <h1 class="app-page-title">User Setting</h1>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">User</a></li>
    <li class="breadcrumb-item active" aria-current="page">Setting</li>
@endsection

@section('content')
    <div class="card">
        <h1 class="card-header text-center">Profile Picture</h1>
        <div class="card-body">
            @livewire('community.user.setting.picture', ['user' => $user])
        </div>
    </div>

    <div class="pt-3 pb-3"></div>

    <div class="card">
        <h1 class="card-header text-center">Password</h1>
        <div class="card-body">
            @livewire('community.user.setting.password', ['user' => $user])
        </div>
    </div>
@endsection

@section('scripts')
@endsection
