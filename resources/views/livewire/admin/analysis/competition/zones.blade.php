@push('styles')
    <style>
        /* .chart{
                    width: 80%;
                    height: 80%;
                } */
    </style>
@endpush

<div>
    <div class="py-3 row">
        <div class="col-lg-4 ms-auto">
            <div wire:ignore>
                <div class="row">
                    <div class="col-2 d-flex justify-content-end">
                        <label for="zone_select" class="col-form-label">{{ __('Zones') }}:</label>
                    </div>
                    <div class="col-10 d-flex align-items-center">
                        <select class="form-select {{ $errors->has('zone_id') ? 'is-invalid' : '' }}" id="zone_select"
                            style="width: 100%">
                            @foreach ($zones as $zoneObj)
                                <option value="{{ $zoneObj->id }}">{{ $zoneObj->getFormalName() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @error('zone_id')
                <div class="invalid-message">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    @php
        $colNum = floor(12 / $submission_categories->count());
    @endphp

    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#carbon_emission_stats" aria-expanded="true" aria-controls="carbon_emission_stats">
                    <strong>{{ __('Carbon Emission Stats for') }} {{ $zone ? $zone->getFormalName() : '' }}</strong>
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
                        <div class="py-3">
                            <h5 class="text-center">{{ __('Total Carbon Emission By Month') }}</h5>
                            <div class="row">
                                <div class="col-lg-10 chart">
                                    <canvas id="total_carbon_emission_each_month_bar_chart_zones"></canvas>
                                </div>
                                <div class="col-lg-2 d-flex justify-content-center align-items-center">
                                    <div id="legends_total_carbon_emission_each_month_bar_chart_zones"></div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3 row">
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Total Carbon Emission') }}</div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($calculation->total_carbon_emission_each_zone[$zone->id], 2) }}
                                                    kgCO<sub>2</sub></div>
                                            </div>
                                            <iconify-icon icon="mdi:periodic-table-carbon-dioxide" height="60">
                                            </iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">
                                                    {{ __('Average Carbon Emission by Month') }}
                                                </div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($average_carbon_emission_by_month, 2) }}
                                                    kgCO<sub>2</sub></div>
                                            </div>
                                            <iconify-icon icon="mdi:periodic-table-carbon-dioxide" height="60">
                                            </iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3 row">
                            @foreach ($submission_categories as $category)
                                @php
                                    if (gettype($category) === 'object') {
                                        $category = (array) $category;
                                    }
                                @endphp

                                <div class="col-lg-{{ $colNum }} mb-4">
                                    <div class="card bg-secondary text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small">
                                                        {{ __('Total Carbon Emission for') }} <br>
                                                        {{ __($category['description']) }}</div>
                                                    <div class="text-lg fw-bold">
                                                        {{ number_format($calculation->total_carbon_emission_each_type_each_zone[$zone->id][$category['name']], 2) }}
                                                        kgCO<sub>2</sub></div>
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
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button text-center" type="button" data-bs-toggle="collapse"
                    data-bs-target="#submission_stats" aria-expanded="false" aria-controls="submission_stats">
                    <strong>{{ __('Submission Stats for') }} {{ $zone ? $zone->getFormalName() : '' }}</strong>
                </button>
            </h2>
            <div id="submission_stats" class="accordion-collapse collapse show"
                aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">

                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Collecting Analysis') }}...</strong>
                        </div>
                    @else
                        <div class="py-3">
                            <h5 class="text-center">{{ __('Total Submission By Month') }}</h5>
                            <div class="row">
                                <div class="col-lg-10 chart">
                                    <canvas id="total_submission_each_month_bar_chart_zones"></canvas>
                                </div>
                                <div class="col-lg-2 d-flex justify-content-center align-items-center">
                                    <div id="legends_total_submission_each_month_bar_chart_zones"></div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3 row">
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Total Submission') }}</div>
                                                <div class="text-lg fw-bold">
                                                    {{ $stat->total_submission_each_zone[$zone->id] }}
                                                    {{ __('Residents') }}</div>
                                            </div>
                                            <iconify-icon icon="vaadin:group" height="60"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">
                                                    {{ __('Average Submission by Month') }}
                                                </div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($average_submission_by_month, 2) }}
                                                    {{ __('Residents') }}</div>
                                            </div>
                                            <iconify-icon icon="vaadin:group" height="60"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3 row">
                            @foreach ($submission_categories as $category)
                            @php
                                if (gettype($category) === 'object') {
                                    $category = (array) $category;
                                }
                            @endphp
                                <div class="col-lg-{{ $colNum }} mb-4">
                                    <div class="card bg-secondary text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small">{{ __('Total Submission for') }}
                                                        <br>
                                                        {{ __($category['description']) }}
                                                    </div>
                                                    <div class="text-lg fw-bold">
                                                        {{ $stat->total_submission_each_type_each_zone[$zone->id][$category['name']] }}
                                                        {{ __('Residents') }}</div>
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
    <script src="{{ asset('js/chart.js/helpers.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#zone_select').select2({
                theme: 'bootstrap-5',
                placeholder: '{{ __('Select Month') }}'
            });

            $('#zone_select').val(@js($zone_id)).trigger('change');

            @this.emit('calculate');

            $('#zone_select').on('change', function(e) {
                var selected_value = $('#zone_select').select2("val");
                @this.set('zone_id', selected_value);
                @this.emit('analysis');
            });
        });

        window.addEventListener('initChart', event => {
            generateChartEachMonthZones(event.detail.months, "total_carbon_emission_each_month_bar_chart_zones",
                '{{ __('Total Carbon Emission') }}',
                event.detail.total_carbon_emission_each_month,
                'tooltips_total_carbon_emission_each_month_bar_chart_zones', 'kgCO<sub>2</sub>',
                'legends_total_carbon_emission_each_month_bar_chart_zones', '{{ __('Month') }}',
                '{{ __('Total Carbon Emission') }}');

            generateChartEachMonthZones(event.detail.months, "total_submission_each_month_bar_chart_zones",
                '{{ __('Total Submission') }}',
                event.detail.total_submission_each_month,
                'tooltips_total_submission_each_month_bar_chart_zones', 'Residents',
                'legends_total_submission_each_month_bar_chart_zones', '{{ __('Month') }}',
                '{{ __('Total Submission') }}');
        })

        function generateChartEachMonthZones(months, canvasID, label, dataByMonth, tooltipsID, symbol, legendsID, xTitle,
            yTitle) {
            let chart = Chart.getChart(canvasID);
            if (typeof chart !== 'undefined')
                chart.destoy();

            const canvas_element = document.getElementById(canvasID);

            const labels = months;
            const datasets = [{
                label: label,
                data: dataByMonth,
                tooltipsID: tooltipsID,
                symbol: symbol
            }].map(value => {
                const color = generateRandomColorRGBA();
                return {
                    ...value,
                    backgroundColor: color,
                    borderColor: color
                }
            })
            const data = {
                labels: labels,
                datasets: datasets
            };
            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        htmlLegend: {
                            containerID: legendsID,
                            symbol: symbol
                        },
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            enabled: false,
                            position: 'nearest',
                            external: externalTooltipHandler,
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: xTitle
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: yTitle
                            },
                            beginAtZero: true
                        }
                    }
                },
                plugins: [htmlLegendPlugin],
            };

            chart = new Chart(canvas_element, config);

            setObserverChart('pills-zones', chart)
        }
    </script>
@endpush
