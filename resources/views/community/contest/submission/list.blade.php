@extends('community.layouts.app')

@section('title', __('Submission Details'))

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-file-pen"></i></div>
                            {{ __('Competition Management') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">{{ __($categoryDescription) }}</div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Competition Management') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('community.contest.competition.list') }}">{{ $submission->competition->year }}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('community.contest.submission.category', ['competition_id' => $submission->competition->id]) }}">{{ __($categoryDescription) }}</a>
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
            <div class="card-header text-center">
                {{ __('Submission Details for') }}<br>{{ $submission->competition->name }}<br>({{ __($categoryDescription) }})
            </div>
            <div class="card-body">
                <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-record-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-record" type="button" role="tab" aria-controls="pills-record"
                            aria-selected="true">{{ __('Record') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-evidence-tab" data-bs-toggle="pill" data-bs-target="#pills-evidence"
                            type="button" role="tab" aria-controls="pills-evidence"
                            aria-selected="false">{{ __('Evidence') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-answer-tab" data-bs-toggle="pill" data-bs-target="#pills-answer"
                            type="button" role="tab" aria-controls="pills-answer"
                            aria-selected="false">{{ __('Bonus Questions') }}</button>
                    </li>
                </ul>
                <div class="tab-content py-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-record" role="tabpanel"
                        aria-labelledby="pills-record-tab" tabindex="0">

                        @livewire('community.contest.record', ['submission' => $submission, 'category' => $category])

                    </div>
                    <div class="tab-pane fade" id="pills-evidence" role="tabpanel" aria-labelledby="pills-evidence-tab"
                        tabindex="0">

                        @livewire('community.contest.evidence', ['submission' => $submission, 'category' => $category])

                    </div>
                    <div class="tab-pane fade" id="pills-answer" role="tabpanel" aria-labelledby="pills-answer-tab"
                        tabindex="0">
                        @livewire('community.contest.answer', ['submission' => $submission, 'category' => $category])

                        {{-- @if ($submission->checkBillsSubmit() === __('Fully Submitted'))
                            @livewire('community.contest.answer', ['submission' => $submission, 'category' => $category])
                        @else
                            <div class="d-flex justify-content-center align-items-center" style="height: 500px">
                                <h2>{{ __('Please submit the record for each month before answer the Bonus Question') }}
                                </h2>
                            </div>
                        @endif --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
