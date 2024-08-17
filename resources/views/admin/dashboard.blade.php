@extends('admin.layouts.app')

@section('title', __('Dashboard'))

@section('styles')
    <!-- LITEPICKER CSS-->
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
@endsection

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            {{ __('Dashboard') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">
                        <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                            <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                            <input class="form-control ps-0 pointer" id="litepickerRangePlugin"
                                placeholder="Select date range..." />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="row py-2">
            <div class="col-lg-12">
                @livewire("admin.dashboard.total-collection")
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @livewire("admin.dashboard.latest-registration")
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
