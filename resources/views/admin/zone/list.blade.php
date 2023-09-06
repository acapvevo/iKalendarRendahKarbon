@extends('admin.layouts.app')

@section('title', __('List of Zone'))

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 750px;
        }
    </style>
@endsection

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                            {{ __('Zone Management') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">{{ __('List of Zone') }}</div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Zone Management') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('List of Zone') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-list-tab" data-bs-toggle="tab" data-bs-target="#nav-list"
                            type="button" role="tab" aria-controls="nav-list"
                            aria-selected="true">{{ __('Zone List') }}</button>
                        <button class="nav-link" id="nav-map-tab" data-bs-toggle="tab" data-bs-target="#nav-map"
                            type="button" role="tab" aria-controls="nav-map"
                            aria-selected="false">{{ __('Zone Map') }}</button>
                    </div>
                </nav>
                <div class="tab-content py-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab"
                        tabindex="0">
                        @livewire('admin.zone', ['zones' => $zones])
                    </div>
                    <div class="tab-pane fade" id="nav-map" role="tabpanel" aria-labelledby="nav-map-tab" tabindex="0">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="{{ asset('js/leaflet/helpers.js') }}"></script>

    <script>
        const map = initLeaflet('map');

        @foreach ($zones as $zone)
            let polygon = setZone(@js($zone->getCoordinateLeaflet()), map);
            polygon.bindTooltip(@js(__('Zone') . ' ' . $zone->number . ': ' . $zone->name), {
                permanent: true,
                direction: "center"
            });
        @endforeach

        setObserver('nav-map', map);
    </script>
@endsection
