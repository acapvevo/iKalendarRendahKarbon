@push('styles')
    <style>
        #map_carbon_emission_overall {
            height: 500px;
        }

        #map_submission_overall {
            height: 500px;
        }
    </style>
@endpush

@php
    $colNum = floor(12 / $submission_categories->count());
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
                        <div class="py-3">
                            <h5 class="text-center">{{ __('Total Carbon Emission By Month') }}</h5>
                            <div class="row">
                                <div class="col-lg-10">
                                    <canvas id="total_carbon_emission_each_month_bar_chart"></canvas>
                                </div>
                                <div class="col-lg-2 d-flex justify-content-center align-items-center">
                                    <div id="legends_total_carbon_emission_each_month_bar_chart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3">
                            <h5 class="text-center">{{ __('Total Carbon Emission By Zone') }}</h5>
                            <div id="map_carbon_emission_overall"></div>
                        </div>

                        <div class="py-3 row">
                            <div class="col-lg-4 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Total Carbon Emission') }}</div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($calculation->total_carbon_emission, 2) }}
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
                                                <div class="text-white-75 small">
                                                    {{ __('Average Carbon Emission by Month') }}
                                                </div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($calculation->average_carbon_emission_by_month, 2) }}
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
                                                <div class="text-white-75 small">
                                                    {{ __('Average Carbon Emission by Zone') }}
                                                </div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($calculation->average_carbon_emission_by_zone, 2) }}
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
                                <div class="col-lg-{{ $colNum }} mb-4">
                                    <div class="card bg-secondary text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small">
                                                        {{ __('Total Carbon Emission for') }} <br>
                                                        {{ __($category->description) }}</div>
                                                    <div class="text-lg fw-bold">
                                                        {{ number_format($calculation->total_carbon_emission_each_type[$category->name], 2) }}
                                                        kgCO<sub>2</sub></div>
                                                </div>
                                                <iconify-icon icon="{{ $category->icon }}"
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
                    <strong>{{ __('Submission Stats') }}</strong>
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
                                <div class="col-lg-10">
                                    <canvas id="total_submission_each_month_bar_chart"></canvas>
                                </div>
                                <div class="col-lg-2 d-flex justify-content-center align-items-center">
                                    <div id="legends_total_submission_each_month_bar_chart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3">
                            <h5 class="text-center">{{ __('Total Submission By Zone') }}</h5>
                            <div id="map_submission_overall"></div>
                        </div>

                        <div class="py-3 row">
                            <div class="col-lg-4 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Total Submission') }}</div>
                                                <div class="text-lg fw-bold">{{ $stat->total_submission }}
                                                    {{ __('Residents') }}</div>
                                            </div>
                                            <iconify-icon icon="vaadin:group" height="60"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">
                                                    {{ __('Average Submission by Month') }}
                                                </div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($stat->average_submission_by_month, 2) }}
                                                    {{ __('Residents') }}</div>
                                            </div>
                                            <iconify-icon icon="vaadin:group" height="60"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">
                                                    {{ __('Average Submission by Zone') }}
                                                </div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($stat->average_submission_by_zone, 2) }}
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
                                <div class="col-lg-{{ $colNum }} mb-4">
                                    <div class="card bg-secondary text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small">{{ __('Total Submission for') }}
                                                        <br>
                                                        {{ __($category->description) }}
                                                    </div>
                                                    <div class="text-lg fw-bold">
                                                        {{ $stat->total_submission_each_type[$category->name] }}
                                                        {{ __('Residents') }}</div>
                                                </div>
                                                <iconify-icon icon="{{ $category->icon }}"
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
            @this.getAnalysis()
        });

        window.addEventListener('initChartAndMap', event => {

            generateChartEachMonthOverall(event.detail.months, "total_carbon_emission_each_month_bar_chart",
                '{{ __('Total Carbon Emission') }}',
                event.detail.total_carbon_emission_each_month,
                'tooltips_total_carbon_emission_each_month_bar_chart', 'kgCO<sub>2</sub>',
                'legends_total_carbon_emission_each_month_bar_chart', '{{ __('Month') }}',
                '{{ __('Total Carbon Emission') }}');

            generateChartEachMonthOverall(event.detail.months, "total_submission_each_month_bar_chart",
                '{{ __('Total Submission') }}',
                event.detail.total_submission_each_month,
                'tooltips_total_submission_each_month_bar_chart', 'Residents',
                'legends_total_submission_each_month_bar_chart', '{{ __('Month') }}',
                '{{ __('Total Submission') }}');

            initMapOverall('map_carbon_emission_overall', event.detail.zones, event.detail
                .total_carbon_emission_each_zone, 'kgCO<sub>2</sub>');

            initMapOverall('map_submission_overall', event.detail.zones, event.detail.total_submission_each_zone,
                @js(__('Residents')));

        })

        function generateChartEachMonthOverall(months, canvasID, label, dataByMonth, tooltipsID, symbol, legendsID, xTitle,
            yTitle) {
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

            new Chart(canvas_element, config);
        }

        function initMapOverall(elementID, zones, data, symbol) {
            let overallMap = initLeaflet(elementID);

            for (let zone of zones) {
                let polygon = setZone([zone['coordinates']], overallMap);
                setPopupData(polygon, @js(__('Zone') . ' ') + zone['number'], zone['name'], data[zone['id']] + ' ' + symbol);
            }

            setObserver('pills-overall', overallMap)
        }
    </script>
@endpush
