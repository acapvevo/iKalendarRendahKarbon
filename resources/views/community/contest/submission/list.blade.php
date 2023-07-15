@extends('community.layouts.app')

@section('title', __('List of Competition'))

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-file-pen"></i></div>
                            {{ __('Competition Submission') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">{{ __('List of Competition') }}</div>
                </div>
                <nav class="pt-3 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Competition Submission') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('community.contest.competition.list') }})">{{ $submission->competition->year }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Submission Details') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header text-center">{{ __('Submission Details') }}</div>
            <div class="card-body">
                @livewire('community.contest.submission', ['submission' => $submission])
            </div>
        </div>
    </div>
@endsection
