@extends('super_admin.layouts.app')

@section('title', 'User Setting')

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="settings"></i></div>
                            User Setting
                        </h1>
                    </div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">Setting</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <h1 class="card-header text-center">Profile Picture</h1>
            <div class="card-body">
                @livewire('super-admin.user.setting.picture', ['user' => $user])
            </div>
        </div>

        <div class="pt-3 pb-3"></div>

        <div class="card">
            <h1 class="card-header text-center">Password</h1>
            <div class="card-body">
                @livewire('super-admin.user.setting.password', ['user' => $user])
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
