@push('styles')
@endpush

@php
    $colNum = 12 / $categories->count();
@endphp

<div>
    <div class="card">
        <h1 class="card-header">{{ __('Collection Details for ') }} {{ $competition->year }}</h1>
        <div class="card-body">
            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-lg-{{ $colNum }}">
                        <div class="card border-start-lg border-start-primary h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="small fw-bold text-primary mb-1">{{ $category->description }}</div>
                                        <div class="h5">
                                            @switch($category->code)
                                                @case('E')
                                                @case('W')
                                                    {{ number_format($calculation->total_usage_each_type[$category->name], 2) }}
                                                    {!! $category->symbol !!}
                                                @break

                                                @case('R')
                                                @case('UO')
                                                    {{ number_format($calculation->total_weight_each_type[$category->name] ?? 0, 2) }}
                                                    {!! $category->symbol !!}
                                                @break
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="ms-2">
                                        <iconify-icon class="fa-4x text-gray-200"
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

@push('scripts')
@endpush
