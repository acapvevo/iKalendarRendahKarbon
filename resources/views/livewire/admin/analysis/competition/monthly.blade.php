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
<div>
    <div class="py-3 row">
        <div class="col-12 col-lg-4 ms-auto">
            <div wire:ignore>
                <div class="row">
                    <div class="col-3 d-flex justify-content-end">
                        <label for="month_select" class="col-form-label">{{ __('Month') }}:</label>
                    </div>
                    <div class="col-9">
                        <select class="form-select {{ $errors->has('month_id') ? 'is-invalid' : '' }}"
                            id="month_select">
                            @foreach ($competition->months as $monthObj)
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

    @php
        [$total_carbon_emission_by_zone, $total_carbon_emission, $average_carbon_emission_by_zone, $total_carbon_emission_by_category] = $carbon_emission_stats;
        [$total_submission_by_zone, $total_submission, $average_submission_by_zone, $total_submission_by_category] = $submission_stats;
        $colNum = 12 / $submission_categories->count();
    @endphp

    <div class="card">
        <div class="card-header text-center">
            {{ __('Carbon Emission Stats for') }} {{ $month ? $month->getName() : '' }}
        </div>
        <div class="card-body">
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
                                            {{ number_format($total_carbon_emission, 2) }}
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
                                            {{ number_format($average_carbon_emission_by_zone, 2) }}
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

    <div class="p-3"></div>

    <div class="card">
        <div class="card-header text-center">
            {{ __('Submission Stats for') }} {{ $month ? $month->getName() : '' }}
        </div>
        <div class="card-body">

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
                                        <div class="text-lg fw-bold">{{ $total_submission }}
                                            {{ __('Communities') }}</div>
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
                                            {{ number_format($average_submission_by_zone, 2) }}
                                            {{ __('Communities') }}</div>
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
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @this.getAnalysis();

            $('#month_select').select2({
                theme: 'bootstrap-5',
                placeholder: '{{ __('Select Month') }}'
            });
            $('#month_select').val(@js($month_id)).trigger('change');

            $('#month_select').on('change', function(e) {
                var selected_value = $('#month_select').select2("val");
                @this.set('month_id', selected_value);
                @this.emit('getAnalysis');
            });
        });

        window.addEventListener('initMap', event => {
            initMap('map_carbon_emission_monthly', event.detail.zones, event.detail.total_carbon_emission_by_zone);
            initMap('map_submission_monthly', event.detail.zones, event.detail.total_submission_by_zone);
        });

        const monthlyTab = document.getElementById('pills-monthly');

        function initMap(elementID, zones, data) {
            if (L.DomUtil.get(elementID) != null) {
                L.DomUtil.get(elementID)._leaflet_id = null;
            }

            let map = L.map(elementID).setView([1.460, 103.614], 12);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

            for (let zone of zones) {
                L.polygon([zone['coordinates']]).addTo(map).bindPopup(zone['name'] + ' ' + data[zone['id']]);
            }

            let observer_map = new MutationObserver(function() {
                if (monthlyTab.style.display != 'none') {
                    map.invalidateSize();
                }
            });
            observer_map.observe(monthlyTab, {
                attributes: true
            });
        }
    </script>
@endpush
