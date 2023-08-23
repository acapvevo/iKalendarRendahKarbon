@extends('community.layouts.app')

@section('title', __('Submission Details'))

@section('styles')
    <style>
        .btn-big {
            height: 250px;
            font-weight: 900;
            font-size: 300%;
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
                            <div class="page-header-icon"><i class="fa-solid fa-file-pen"></i></div>
                            {{ __('Competition Management') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">{{ __('Submission Category') }}</div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Competition Management') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('community.contest.competition.list') }}">{{ $competition->year }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Submission Category') }}</li>
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
                {{ __('Choose Category of Submission for') }} {{ $competition->name }}
            </div>
            <div class="card-body">
                <form action="{{route('community.contest.submission.list')}}" method="post">
                    @csrf
                    <input type="hidden" name="competition_id" value="{{ $competition->id }}">

                    <div class="container text-center">
                        <div class="row row-cols-1 row-cols-lg-2 g-3 g-lg-4">
                            @foreach ($submission_category as $category)
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-big" type="submit" value="{{ $category->code }}"
                                        name="category">{{ __($category->description) }}</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
