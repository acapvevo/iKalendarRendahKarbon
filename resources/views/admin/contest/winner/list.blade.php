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
                    <div class="col-12 col-xl-auto mt-4">{{ __('List Of Winners') }}</div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Competition Management') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('List Of Winners') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header text-center">{{ __('List Of Winners for') }} <br> {{ $currentCompetition->name }}
            </div>
            <div class="card-body">
                <div class="py-3 d-flex justify-content-end row">
                    <form action="{{ route('admin.contest.winner.list') }}" method="post">
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
                            <button type="submit" class="btn btn-primary"
                                formaction="{{ route('admin.contest.winner.export') }}"
                                formtarget="_blank">{{ __('Export Result') }}</button>
                        </div>
                    </form>
                </div>

                <div class="py-3">
                    @livewire('admin.contest.winner', ['competition' => $currentCompetition])
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
