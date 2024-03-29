@extends('admin.layouts.app')

@section('title', __('List of Activity'))

@push('styles')
@endpush

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-people-carry-box"></i></div>
                            {{ __('Activity Management') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">{{ __('List of Activity') }}</div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Activity Management') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('List of Activity') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header text-center">{{ __('List of Activity') }}</div>
            <div class="card-body">
                @livewire('admin.activity', ['activities' => $activities])
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
