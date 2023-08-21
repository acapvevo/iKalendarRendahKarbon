@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
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
[
$total_carbon_emission_by_month,
$total_carbon_emission_by_zone,
$average_carbon_emission_by_month,
$average_carbon_emission_by_zone,
$total_carbon_emission_by_category,
$total_carbon_emission
] = $carbon_emission_stats;

[
$total_submission_by_month,
$total_submission_by_zone,
$average_submission_by_month,
$average_submission_by_zone,
$total_submission_by_category,
$total_submission
] = $submission_stats;
$colNum = floor(12 / $submission_categories->count());
@endphp

<div>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#carbon_emission_stats" aria-expanded="true"
                    aria-controls="carbon_emission_stats">
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
                                <canvas id="total_carbon_emission_by_month_bar_chart"></canvas>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-center align-items-center">
                                <div id="legends_total_carbon_emission_by_month_bar_chart"></div>
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
                                            <div class="text-lg fw-bold">{{ number_format($total_carbon_emission, 2) }}
                                                kgCO<sub>2</sub></div>
                                        </div>
                                        <iconify-icon icon="mdi:periodic-table-carbon-dioxide" height="60"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">{{ __('Average Carbon Emission by Month') }}
                                            </div>
                                            <div class="text-lg fw-bold">
                                                {{ number_format($average_carbon_emission_by_month, 2) }}
                                                kgCO<sub>2</sub></div>
                                        </div>
                                        <iconify-icon icon="mdi:periodic-table-carbon-dioxide" height="60"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">{{ __('Average Carbon Emission by Zone') }}
                                            </div>
                                            <div class="text-lg fw-bold">
                                                {{ number_format($average_carbon_emission_by_zone, 2) }}
                                                kgCO<sub>2</sub></div>
                                        </div>
                                        <iconify-icon icon="mdi:periodic-table-carbon-dioxide" height="60"></iconify-icon>
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
                                            <div class="text-white-75 small">{{ __('Total Carbon Emission for') }} <br>
                                                {{ __($category->description) }}</div>
                                            <div class="text-lg fw-bold">
                                                {{ number_format($total_carbon_emission_by_category[$category->name], 2) }}
                                                {!! $category->symbol !!}</div>
                                        </div>
                                        <iconify-icon icon="{{ $category->icon }}" height="60"></iconify-icon>
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
                    data-bs-target="#submission_stats" aria-expanded="false"
                    aria-controls="submission_stats">
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
                                <canvas id="total_submission_by_month_bar_chart"></canvas>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-center align-items-center">
                                <div id="legends_total_submission_by_month_bar_chart"></div>
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
                                            <div class="text-lg fw-bold">{{ $total_submission }}
                                                {{ __('Communities') }}</div>
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
                                            <div class="text-white-75 small">{{ __('Average Submission by Month') }}</div>
                                            <div class="text-lg fw-bold">
                                                {{ number_format($average_submission_by_month, 2) }}
                                                {{ __('Communities') }}</div>
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
                                            <div class="text-white-75 small">{{ __('Average Submission by Zone') }}</div>
                                            <div class="text-lg fw-bold">
                                                {{ number_format($average_submission_by_zone, 2) }}
                                                {{ __('Communities') }}</div>
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
                                            <div class="text-white-75 small">{{ __('Total Submission for') }} <br>
                                                {{ __($category->description) }}</div>
                                            <div class="text-lg fw-bold">
                                                {{ $total_submission_by_category[$category->name] }}
                                                {{ __('Communities') }}</div>
                                        </div>
                                        <iconify-icon icon="{{ $category->icon }}" height="60"></iconify-icon>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.3/chart.umd.js"
    integrity="sha512-wv0y1q2yUeK6D55tLrploHgbqz7ZuGB89rWPqmy6qOR9TmmzYO69YZYbGIYDmqmKG0GwOHQXlKwPyOnJ95intA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/chart.js/colors.js') }}"></script>
<script src="{{ asset('js/chart.js/fonts.js') }}"></script>
<script src="{{ asset('js/chart.js/legends.js') }}"></script>
<script src="{{ asset('js/chart.js/tooltips.js') }}"></script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    const overallTab = document.getElementById('pills-overall');

        document.addEventListener('DOMContentLoaded', function() {
            @this.getAnalysis()
        });

        window.addEventListener('initChartAndMap', event => {

            generateChartByMonth(event.detail.months, "total_carbon_emission_by_month_bar_chart",
                '{{ __('Total Carbon Emission') }}',
                event.detail.total_carbon_emission_by_month,
                'tooltips_total_carbon_emission_by_month_bar_chart', 'kgCO<sub>2</sub>',
                'legends_total_carbon_emission_by_month_bar_chart', '{{ __('Month') }}',
                '{{ __('Total Carbon Emission') }}');

            generateChartByMonth(event.detail.months, "total_submission_by_month_bar_chart",
                '{{ __('Total Submission') }}',
                event.detail.total_submission_by_month,
                'tooltips_total_submission_by_month_bar_chart', 'Communities',
                'legends_total_submission_by_month_bar_chart', '{{ __('Month') }}',
                '{{ __('Total Submission') }}');

            initMap('map_carbon_emission_overall', event.detail.zones, event.detail.total_carbon_emission_by_zone);

            initMap('map_submission_overall', event.detail.zones, event.detail.total_submission_by_zone);

        })

        function generateChartByMonth(months, canvasID, label, dataByMonth, tooltipsID, symbol, legendsID, xTitle, yTitle) {
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

        function initMap(elementID, zones, data) {
            let map = L.map(elementID).setView([1.460, 103.614], 12);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

            for (let zone of zones) {
                let polygon = L.polygon([zone['coordinates']]).addTo(map);
                polygon.bindPopup(zone['name'] + ' ' + data[zone['id']]);
            }

            let observer_map = new MutationObserver(function() {
                if (overallTab.style.display != 'none') {
                    map.invalidateSize();
                }
            });
            observer_map.observe(overallTab, {
                attributes: true
            });
        }
</script>
@endpush
