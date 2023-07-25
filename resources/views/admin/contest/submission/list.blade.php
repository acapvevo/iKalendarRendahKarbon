@extends('admin.layouts.app')

@section('title', __('List of Submission'))

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
                    <div class="col-12 col-xl-auto mt-4">{{ __('List of Submission') }}</div>
                </div>
                <nav class="pt-3 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Competition Management') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.contest.competition.list') }}">{{ $currentCompetition->year }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('List of Submission') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header text-center">{{ __('List of Submission for') }} <br> {{ $currentCompetition->name }}
            </div>
            <div class="card-body">
                <div class="py-3 d-flex justify-content-end row">
                    <form action="{{ route('admin.contest.submission.list') }}" method="get">
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

                @livewire('admin.contest.submission', ['competition_id' => $currentCompetition->id])
            </div>
        </div>
    </div>
@endsection
