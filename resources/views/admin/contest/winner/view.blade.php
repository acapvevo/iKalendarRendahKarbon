@extends('admin.layouts.app')

@section('title', __('Competition Analysis'))

@section('styles')
@endsection

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="bar-chart-2"></i></div>
                            {{ __('Competition Management') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">{{ __('Submission Detail') }}</div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Competition Management') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.contest.winner.list') }}">{{ __('List Of Winners') }}</a></li>
                        <li class="breadcrumb-item active">
                            {{ $submission->community->name ?? $submission->community->username }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header text-center">{{ __('Submission Details for') }} <br>
                {{ $submission->community->name ?? $submission->community->username }}
            </div>
            <div class="card-body">

                <nav>
                    <div class="nav nav-tabs nav-justified" id="nav" role="tablist">
                        <button class="nav-link active" id="nav-analysis-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-analysis-content" type="button" role="tab"
                            aria-controls="nav-analysis-content" aria-selected="true">{{ __('Analysis') }}</button>
                        <button class="nav-link" id="nav-record-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-record-content" type="button" role="tab"
                            aria-controls="nav-record-content" aria-selected="false">{{ __('Records') }}</button>
                        <button class="nav-link" id="nav-answer-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-answer-content" type="button" role="tab"
                            aria-controls="nav-answer-content" aria-selected="false">{{ __('Bonus Question') }}</button>
                        <button class="nav-link" id="nav-finance-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-finance-content" type="button" role="tab"
                            aria-controls="nav-finance-content"
                            aria-selected="false">{{ __('Finance Information') }}</button>
                    </div>
                </nav>
                <div class="tab-content py-3" id="navContent">
                    <div class="tab-pane fade show active" id="nav-analysis-content" role="tabpanel"
                        aria-labelledby="nav-analysis-tab" tabindex="0">

                        <div class="table-responsive-lg">
                            <table class="table table-bordered">
                                <tr>
                                    <th></th>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="nav-record-content" role="tabpanel" aria-labelledby="nav-record-tab"
                        tabindex="0">

                    </div>
                    <div class="tab-pane fade" id="nav-answer-content" role="tabpanel" aria-labelledby="nav-answer-tab"
                        tabindex="0">

                    </div>
                    <div class="tab-pane fade" id="nav-finance-content" role="tabpanel" aria-labelledby="nav-finance-tab"
                        tabindex="0">
                        @livewire('admin.contest.finance', ['submission' => $submission])
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
