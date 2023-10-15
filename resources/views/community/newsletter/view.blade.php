@extends('community.layouts.app')

@section('title', __('View Newsletter'))

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-regular fa-newspaper"></i></div>
                            {{ __('Newsletter') }}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">{{ __('View Newsletter') }}</div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('Newsletter') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('community.newsletter.list') }}">{{ __('List of Newsletter') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('View Newsletter') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <img src="{{ route('community.newsletter.thumbnail', ['newsletter_id' => $newsletter->id]) }}"
                class="card-img-top" alt="{{ $newsletter->thumbnail }}" style="height: 500px; object-fit: contain;">
            <div class="card-body">
                <h5 class="card-title">{{ $newsletter->title }}</h5>
                <small>{{ __($newsletter->getCategory()->description ?? '') }} /
                    {{ __('By ') . strtoupper($newsletter->admin->name) }} /
                    {{ $newsletter->location }} /
                    {{ $newsletter->getCreatedAt() }}</small>

                <p class="card-text py-3">{!! $newsletter->content !!}</p>
            </div>
        </div>
    </div>
@endsection
