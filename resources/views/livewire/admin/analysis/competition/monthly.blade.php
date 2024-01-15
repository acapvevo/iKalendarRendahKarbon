@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        #map_carbon_emission_monthly {
            height: 500px;
        }

        #map_submission_monthly {
            height: 500px;
        }
    </style>
@endpush

@php
    $colNum = 12 / $submission_categories->count();
@endphp

<div>
    <div class="py-3 row">
        <div class="col-lg-4 ms-auto">
            <div wire:ignore>
                <div class="row">
                    <div class="col-2 d-flex justify-content-end">
                        <label for="month_select" class="col-form-label">{{ __('Month') }}:</label>
                    </div>
                    <div class="col-10 d-flex align-items-center">
                        <select class="form-select {{ $errors->has('month_id') ? 'is-invalid' : '' }}" id="month_select"
                            data-placeholder="{{ __('Select Month') }}" data-width="100%">
                            @foreach ($competition->getMonthRange() as $monthObj)
                                <option value="{{ $monthObj->id }}">{{ $monthObj->getName() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @error('month_id')
                <div class="invalid-message">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

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
                            <h5 class="text-center">{{ __('Total Carbon Emission By Zone') }}</h5>
                            <div id="map_carbon_emission_monthly"></div>
                        </div>

                        <div class="py-3 row">
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Total Carbon Emission') }}</div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($calculation->total_carbon_emission, 2) }}
                                                    kgCO<sub>2</sub></div>
                                            </div>
                                            <iconify-icon icon="mdi:periodic-table-carbon-dioxide"
                                                height="60"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Average Carbon Emission by Zone') }}
                                                </div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($calculation->average_carbon_emission_by_zone, 2) }}
                                                    kgCO<sub>2</sub></div>
                                            </div>
                                            <iconify-icon icon="mdi:periodic-table-carbon-dioxide"
                                                height="60"></iconify-icon>
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
                                                        {{ number_format($calculation->total_carbon_emission_each_type[$category->name], 2) }}
                                                        kgCO<sub>2</sub></div>
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
                            <h5 class="text-center">{{ __('Total Submission By Zone') }}</h5>
                            <div id="map_submission_monthly"></div>
                        </div>

                        <div class="py-3 row">
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Total Submission') }}</div>
                                                <div class="text-lg fw-bold">{{ $stat->total_submission }}
                                                    {{ __('Residents') }}</div>
                                            </div><iconify-icon icon="vaadin:group" height="60"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">{{ __('Average Submission by Zone') }}</div>
                                                <div class="text-lg fw-bold">
                                                    {{ number_format($stat->average_submission_by_zone, 2) }}
                                                    {{ __('Residents') }}</div>
                                            </div><iconify-icon icon="vaadin:group" height="60"></iconify-icon>
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
                                                        {{ $stat->total_submission_each_type[$category->name] }}
                                                        {{ __('Residents') }}</div>
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
    <script>
        var map = {
            map_carbon_emission_monthly: null,
            map_submission_monthly: null,
        };

        document.addEventListener('DOMContentLoaded', function() {
            @this.emit('map');

            initSelect2("{{ LaravelLocalization::getCurrentLocale() }}", '#month_select', null, function(e) {
                var selected_value = $('#month_select').select2("val");
                @this.set('month_id', selected_value);
                @this.emit('analysis');
            });

            $('#month_select').val(@js($month_id)).trigger('change');
        });

        window.addEventListener('initMap', event => {
            initMapMonthly('map_carbon_emission_monthly', event.detail.zones, event.detail
                .total_carbon_emission_each_zone, 'kgCO<sub>2</sub>');
            initMapMonthly('map_submission_monthly', event.detail.zones, event.detail.total_submission_each_zone,
                @js(__('Residents')));
        });

        function initMapMonthly(elementID, zones, data, symbol) {
            if (map[elementID] !== undefined && map[elementID] !== null) {
                map[elementID].remove();
            }

            map[elementID] = initLeaflet(elementID);

            for (let zone of zones) {
                let polygon = setZone([zone['coordinates']], map[elementID]);
                setPopupData(polygon, @js(__('Zone') . ' ') + zone['number'], zone['name'], data[zone['id']] + ' ' + symbol);
            }

            setObserver('pills-monthly', map[elementID]);
        }
    </script>
@endpush
