@extends('admin.layouts.app')

@section('title', __('List of Question'))

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="award"></i></div>
                            {{ __('Competition Management') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">{{ __('List of Question') }}</div>
                </div>
                <nav class="pt-3 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Competition Management') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.contest.competition.list') }}">{{ $competition->year }}</a></li>
                        <li class="breadcrumb-item active">{{ __('List of Question') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header text-center">{{ __('List of Question for') }} <br> {{ $competition->name }}</div>
            <div class="card-body">
                @livewire('admin.contest.question', ['competition' => $competition])
            </div>
        </div>
    </div>
@endsection
