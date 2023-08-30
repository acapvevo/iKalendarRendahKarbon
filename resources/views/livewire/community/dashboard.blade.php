@push('styles')
@endpush

<div>
    {{-- Submission Stats --}}
    <div class="py-3">
        <div class="card">
            <h2 class="card-header text-center">{{ __('Submission Stats') }}</h2>
            <div class="card-body">
                <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-year-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-year" type="button" role="tab" aria-controls="pills-year"
                            aria-selected="true">{{ __('Current Year') }}: {{ $competition->year }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-month-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-month" type="button" role="tab" aria-controls="pills-month"
                            aria-selected="false">{{ __('Current Month') }}: {{ $bill->month->getName() }}
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-year" role="tabpanel"
                        aria-labelledby="pills-year-tab" tabindex="0">

                        <div class="row">
                            @php
                                $colNumXL = floor(12 / $submission_categories->count());
                                $colNumMD = floor(24 / $submission_categories->count());

                                [$total_carbon_emission_by_category] = $submission->getCarbonEmissionStats();
                            @endphp

                            @foreach ($submission_categories as $category)
                                <div class="col-xl-{{ $colNumXL }} col-md-{{ $colNumMD }} mb-4">
                                    <div class="card border-start-lg border-start-primary h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <div class="small fw-bold text-primary mb-1">
                                                        {{ __($category->description) }}
                                                    </div>
                                                    <div class="h3">
                                                        {{ number_format($total_carbon_emission_by_category[$category->name], 2) }}
                                                        kgCO<sub>2</sub>
                                                    </div>
                                                    <div
                                                        class="text-xs fw-bold text-success d-inline-flex align-items-center">
                                                        <i class="me-1" data-feather="trending-up"></i>
                                                        12%
                                                    </div>
                                                </div>
                                                <div class="ms-2">
                                                    <iconify-icon class="text-gray-200 fa-4x"
                                                        icon="{{ $category->icon }}"></iconify-icon>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab"
                        tabindex="0">

                        <div class="row">
                            @php
                                $colNumXL = floor(12 / $submission_categories->count());
                                $colNumMD = floor(24 / $submission_categories->count());

                                [$total_carbon_emission_by_category] = $bill->getCarbonEmissionStats();
                            @endphp

                            @foreach ($submission_categories as $category)
                                <div class="col-xl-{{ $colNumXL }} col-md-{{ $colNumMD }} mb-4">
                                    <div class="card border-start-lg border-start-primary h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <div class="small fw-bold text-primary mb-1">
                                                        {{ __($category->description) }}
                                                    </div>
                                                    <div class="h3">
                                                        {{ number_format($total_carbon_emission_by_category[$category->name], 2) }}
                                                        kgCO<sub>2</sub>
                                                    </div>
                                                    <div
                                                        class="text-xs fw-bold text-success d-inline-flex align-items-center">
                                                        <i class="me-1" data-feather="trending-up"></i>
                                                        12%
                                                    </div>
                                                </div>
                                                <div class="ms-2">
                                                    <iconify-icon class="text-gray-200 fa-4x"
                                                        icon="{{ $category->icon }}"></iconify-icon>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Newsletter --}}
    <div class="py-3 row">
        <div class="col-lg-8">
            <div class="card">
                <h2 class="card-header text-center">{{ __('Newsletter') }}</h2>
                <div class="card-body">
                    <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                        @foreach ($newsletter_categories as $index => $category)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                    id="pills-{{ $category->name }}-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-{{ $category->name }}" type="button" role="tab"
                                    aria-controls="pills-{{ $category->name }}"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">{{ __($category->description) }}</button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        @foreach ($newsletter_categories as $index => $category)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                id="pills-{{ $category->name }}" role="tabpanel"
                                aria-labelledby="pills-{{ $category->name }}-tab" tabindex="0">

                                @php
                                    $newsletterList = $newsletters->get($category->code);
                                @endphp

                                <div id="carouselNewsletter{{ $category->name }}" class="carousel slide py-3"
                                    data-bs-ride="false">
                                    <div class="carousel-indicators">
                                        @for ($i = 0; $i < 3; $i++)
                                            <button type="button"
                                                data-bs-target="#carouselNewsletter{{ $category->name }}"
                                                data-bs-slide-to="{{ $i }}" {!! $i === 0 ? 'class="active" aria-current="true"' : '' !!}
                                                aria-label="Slide {{ $i + 1 }}"></button>
                                        @endfor
                                    </div>
                                    <div class="carousel-inner">
                                        @for ($i = 0; $i < 3; $i++)
                                            @if ($newsletterList->has($i))
                                                @php
                                                    $newsletter = $newsletterList->get($i);
                                                @endphp
                                                <div class="carousel-item {!! $i === 0 ? 'active' : '' !!}">
                                                    <img src="{{ route('community.newsletter.thumbnail', ['newsletter_id' => $newsletter->id]) }}"
                                                        class="d-block w-100 ratio ratio-16x9"
                                                        alt="{{ $newsletter->thumbnail }}">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <a class="text-white"
                                                            href="{{ route('community.newsletter.view', ['id' => $newsletter->id]) }}">
                                                            <h5 class="text-white">{{ $newsletter->title }}</h5>
                                                        </a>
                                                        <p>{{ $newsletter->getCreatedAt() }}</p>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="carousel-item {!! $i === 0 ? 'active' : '' !!}">
                                                    <img src="{{ asset('assets/img/default.jpg') }}"
                                                        class="d-block w-100" alt="{{ __('Newsletter') }}">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <h5 class="text-white">{{ __('Newsletter') }}</h5>
                                                        <p>{{ __('Wait for more news from us') }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endfor
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselNewsletter{{ $category->name }}"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">{{ __('Previous') }}</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselNewsletter{{ $category->name }}"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">{{ __('Next') }}</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
