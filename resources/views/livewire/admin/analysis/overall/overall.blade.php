@push('styles')
@endpush

<div>
    <div class="accordion" id="stats">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panels_carbon_emission">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#carbon_emission_stats" aria-expanded="true" aria-controls="carbon_emission_stats">
                    <strong>{{ __('Carbon Emission Stats') }}</strong>
                </button>
            </h2>
            <div id="carbon_emission_stats" class="accordion-collapse collapse show"
                aria-labelledby="panels_carbon_emission">
                <div class="accordion-body">
                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Collecting Analysis') }}...</strong>
                        </div>
                    @else
                        <div class="py-3 row">
                            <div class="col-12">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Total Carbon Emission') }}</div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($total['carbon_emission'], 2) }}
                                                    kgCO<sub>2</sub></div>
                                            </div>
                                            <iconify-icon icon="mdi:periodic-table-carbon-dioxide" height="60">
                                            </iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3">
                            @foreach ($categories->chunk(4) as $category_array)
                                <div class="row">
                                    @php
                                        $colNum = floor(12 / $category_array->count());
                                    @endphp
                                    @foreach ($category_array as $category)
                                        <div class="col-lg-{{ $colNum }} mb-4">
                                            <div class="card bg-secondary text-white h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="me-3">
                                                            <div class="py-1">
                                                                <div class="text-white-75 small">
                                                                    {{ __('Total Carbon Emission for') }} <br>
                                                                    {{ __($category['description']) }}</div>
                                                                <div class="text-lg fw-bold">
                                                                    {{ number_format($total_by_type['carbon_emission'][$category['name']], 2) }}
                                                                    kgCO<sub>2</sub>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <iconify-icon icon="{{ $category['icon'] }}"
                                                            height="60"></iconify-icon>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panels_weight">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#weight_stats" aria-expanded="false" aria-controls="weight_stats">
                    <strong>{{ __('Weight Stats') }}</strong>
                </button>
            </h2>
            <div id="weight_stats" class="accordion-collapse collapse" aria-labelledby="panels_weight">
                <div class="accordion-body">
                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Collecting Analysis') }}...</strong>
                        </div>
                    @else
                        <div class="py-3">
                            @php
                                $weight_categories = $categories->filter(function ($category) {
                                    return collect(json_decode($category['variables']))->contains('weight');
                                });
                            @endphp
                            @foreach ($weight_categories->chunk(4) as $category_array)
                                <div class="row">
                                    @php
                                        $colNum = floor(12 / $category_array->count());
                                    @endphp
                                    @foreach ($category_array as $category)
                                        <div class="col-lg-{{ $colNum }} mb-4">
                                            <div class="card bg-secondary text-white h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="me-3">
                                                            <div class="py-1">
                                                                <div class="text-white-75 small">
                                                                    {{ __('Total Weight for') }} <br>
                                                                    {{ __($category['description']) }}</div>
                                                                <div class="text-lg fw-bold">
                                                                    {{ number_format($total_by_type['weight'][$category['name']], 2) }}
                                                                    kg
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <iconify-icon icon="{{ $category['icon'] }}"
                                                            height="60"></iconify-icon>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panels_value">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#value_stats" aria-expanded="false" aria-controls="value_stats">
                    <strong>{{ __('Sell Value Stats') }}</strong>
                </button>
            </h2>
            <div id="value_stats" class="accordion-collapse collapse" aria-labelledby="panels_value">
                <div class="accordion-body">
                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Collecting Analysis') }}...</strong>
                        </div>
                    @else
                        <div class="py-3">
                            @php
                                $value_categories = $categories->filter(function ($category) {
                                    return collect(json_decode($category['variables']))->contains('value');
                                });
                            @endphp
                            @foreach ($value_categories->chunk(4) as $category_array)
                                <div class="row">
                                    @php
                                        $colNum = floor(12 / $category_array->count());
                                    @endphp
                                    @foreach ($category_array as $category)
                                        <div class="col-lg-{{ $colNum }} mb-4">
                                            <div class="card bg-secondary text-white h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="me-3">
                                                            <div class="py-1">
                                                                <div class="text-white-75 small">
                                                                    {{ __('Total Sell Value for') }} <br>
                                                                    {{ __($category['description']) }}</div>
                                                                <div class="text-lg fw-bold">
                                                                    RM
                                                                    {{ number_format($total_by_type['value'][$category['name']], 2) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <iconify-icon icon="{{ $category['icon'] }}"
                                                            height="60"></iconify-icon>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panels_usage">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#usage_stats" aria-expanded="false" aria-controls="usage_stats">
                    <strong>{{ __('Usage Stats') }}</strong>
                </button>
            </h2>
            <div id="usage_stats" class="accordion-collapse collapse" aria-labelledby="panels_usage">
                <div class="accordion-body">
                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Collecting Analysis') }}...</strong>
                        </div>
                    @else
                        <div class="py-3">
                            @php
                                $usage_categories = $categories->filter(function ($category) {
                                    return collect(json_decode($category['variables']))->contains('usage');
                                });
                            @endphp
                            @foreach ($usage_categories->chunk(4) as $category_array)
                                <div class="row">
                                    @php
                                        $colNum = floor(12 / $category_array->count());
                                    @endphp
                                    @foreach ($category_array as $category)
                                        <div class="col-lg-{{ $colNum }} mb-4">
                                            <div class="card bg-secondary text-white h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="me-3">
                                                            <div class="py-1">
                                                                <div class="text-white-75 small">
                                                                    {{ __('Total Usage for') }} <br>
                                                                    {{ __($category['description']) }}</div>
                                                                <div class="text-lg fw-bold">
                                                                    {{ number_format($total_by_type['usage'][$category['name']], 2) }}
                                                                    {!! $category['symbol'] !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <iconify-icon icon="{{ $category['icon'] }}"
                                                            height="60"></iconify-icon>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panels_charge">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#charge_stats" aria-expanded="false" aria-controls="charge_stats">
                    <strong>{{ __('Bill Charge Stats') }}</strong>
                </button>
            </h2>
            <div id="charge_stats" class="accordion-collapse collapse" aria-labelledby="panels_charge">
                <div class="accordion-body">
                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Collecting Analysis') }}...</strong>
                        </div>
                    @else
                        <div class="py-3">
                            @php
                                $charge_categories = $categories->filter(function ($category) {
                                    return collect(json_decode($category['variables']))->contains('charge');
                                });
                            @endphp
                            @foreach ($charge_categories->chunk(4) as $category_array)
                                <div class="row">
                                    @php
                                        $colNum = floor(12 / $category_array->count());
                                    @endphp
                                    @foreach ($category_array as $category)
                                        <div class="col-lg-{{ $colNum }} mb-4">
                                            <div class="card bg-secondary text-white h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="me-3">
                                                            <div class="py-1">
                                                                <div class="text-white-75 small">
                                                                    {{ __('Total Usage for') }} <br>
                                                                    {{ __($category['description']) }}</div>
                                                                <div class="text-lg fw-bold">
                                                                    RM
                                                                    {{ number_format($total_by_type['charge'][$category['name']], 2) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <iconify-icon icon="{{ $category['icon'] }}"
                                                            height="60"></iconify-icon>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @this.emit('analysis');
        });

        window.addEventListener('initChartAndMap', event => {

        })
    </script>
@endpush
