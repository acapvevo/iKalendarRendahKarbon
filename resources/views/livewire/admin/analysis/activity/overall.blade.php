@push('styles')
@endpush

@php
    $colNum = floor(12 / $activity_categories->count());
@endphp

<div>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#carbon_emission_stats" aria-expanded="true" aria-controls="carbon_emission_stats">
                    <strong>{{ __('Carbon Emission Stats') }}</strong>
                </button>
            </h2>
            <div id="carbon_emission_stats" class="accordion-collapse collapse show"
                aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Collecting Analysis') }}...</strong>
                        </div>
                    @else
                        <div class="py-3 row">
                            <div class="col-lg-4 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Total Carbon Emission') }}</div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($analysis['total_carbon_emission'], 2) }}
                                                    kgCO<sub>2</sub></div>
                                            </div>
                                            <iconify-icon icon="mdi:periodic-table-carbon-dioxide" height="60">
                                            </iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Total Weight') }}</div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($analysis['total_weight'], 2) }}
                                                    kg</div>
                                            </div>
                                            <iconify-icon icon="mdi:periodic-table-carbon-dioxide" height="60">
                                            </iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Total Sell Value') }}</div>
                                                <div class="text-lg fw-bold">
                                                    RM {{ number_format($analysis['total_value'], 2) }}
                                                </div>
                                            </div>
                                            <iconify-icon icon="mdi:periodic-table-carbon-dioxide" height="60">
                                            </iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3 row">
                            @foreach ($activity_categories as $category)
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
                                                            {{ number_format($analysis['total_carbon_emission_each_category'][$category['name']], 2) }}
                                                            kgCO<sub>2</sub>
                                                        </div>
                                                    </div>
                                                    <div class="py-1">
                                                        <div class="text-white-75 small">
                                                            {{ __('Total Weight for') }} <br>
                                                            {{ __($category['description']) }}</div>
                                                        <div class="text-lg fw-bold">
                                                            {{ number_format($analysis['total_weight_each_category'][$category['name']], 2) }}
                                                            kg</div>
                                                    </div>
                                                    <div class="py-1">
                                                        <div class="text-white-75 small">
                                                            {{ __('Total Sell Value for') }} <br>
                                                            {{ __($category['description']) }}</div>
                                                        <div class="text-lg fw-bold">
                                                            RM
                                                            {{ number_format($analysis['total_value_each_category'][$category['name']], 2) }}
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
