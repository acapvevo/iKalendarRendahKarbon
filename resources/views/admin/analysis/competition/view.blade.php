@extends('admin.layouts.app')

@section('title', __('Competition Analysis'))

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endsection

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="bar-chart-2"></i></div>
                            {{ __('Analysis Management') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">{{ __('Competition Analysis') }}</div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Analysis Management') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Competition Analysis') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header text-center">{{ __('Competition Analysis for') }} <br> {{ $currentCompetition->name }}
            </div>
            <div class="card-body">
                <div class="py-3 d-flex justify-content-end row">
                    <form action="{{ route('admin.analysis.competition.view') }}" method="post">
                        @csrf

                        <div class="input-group">
                            <select class="form-select {{ $errors->has('competition_id') ? 'is-invalid' : '' }}"
                                name="competition_id">
                                <option hidden>{{ __('Select Competition Year') }}</option>
                                @foreach ($competitions as $competition)
                                    <option value="{{ $competition->id }}">
                                        {{ $competition->year }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">{{ __('Change Competition') }}</button>
                        </div>
                    </form>
                </div>

                <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-overall-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-overall" type="button" role="tab" aria-controls="pills-overall"
                            aria-selected="true">{{ __('Overall') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-monthly-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-monthly" type="button" role="tab" aria-controls="pills-monthly"
                            aria-selected="false">{{ __('Monthly') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-zones-tab" data-bs-toggle="pill" data-bs-target="#pills-zones"
                            type="button" role="tab" aria-controls="pills-zones"
                            aria-selected="false">{{ __('Zones') }}</button>
                    </li>
                </ul>
                <div class="tab-content py-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-overall" role="tabpanel"
                        aria-labelledby="pills-overall-tab" tabindex="0">
                        @livewire('admin.analysis.competition.overall', ['competition' => $currentCompetition])
                    </div>
                    <div class="tab-pane fade" id="pills-monthly" role="tabpanel" aria-labelledby="pills-monthly-tab"
                        tabindex="0">
                        @livewire('admin.analysis.competition.monthly', ['competition' => $currentCompetition])
                    </div>
                    <div class="tab-pane fade" id="pills-zones" role="tabpanel" aria-labelledby="pills-zones-tab"
                        tabindex="0">
                        @livewire('admin.analysis.competition.zones', ['competition' => $currentCompetition])
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.3/chart.umd.js"
        integrity="sha512-wv0y1q2yUeK6D55tLrploHgbqz7ZuGB89rWPqmy6qOR9TmmzYO69YZYbGIYDmqmKG0GwOHQXlKwPyOnJ95intA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/chart.js/colors.js') }}"></script>
    <script src="{{ asset('js/chart.js/fonts.js') }}"></script>
    <script src="{{ asset('js/chart.js/legends.js') }}"></script>
    <script src="{{ asset('js/chart.js/tooltips.js') }}"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="{{ asset('js/leaflet/helpers.js') }}"></script>
@endsection
