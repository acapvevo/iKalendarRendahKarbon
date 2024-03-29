@extends('admin.layouts.app')

@section('title', __('List of Resident'))

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="award"></i></div>
                            {{ __('Participant Management') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">{{ __('List of Resident') }}</div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Participant Management') }}</a></li>
                        @if ($resident)
                        <li class="breadcrumb-item"><a href="{{route('admin.participant.resident.list')}}">{{ $resident->name ?? $resident->username }}</a></li>
                        @endif
                        <li class="breadcrumb-item active">{{ __('List of Resident') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header text-center">
                @if ($resident)
                    {{ __('List of Resident for') }} {{ $resident->name ?? $resident->username }}
                @else
                    {{ __('List of Resident') }}
                @endif
            </div>
            <div class="card-body">
                @livewire('admin.participant.community', ['resident_id' => $resident->id ?? null])
            </div>
        </div>
    </div>
@endsection
