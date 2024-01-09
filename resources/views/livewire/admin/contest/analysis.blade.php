@push('styles')
@endpush

<div>
    @if ($isLoading)
        <div class="d-flex align-items-center justify-content-center loading">
            <span class="spinner-border text-primary" role="status">
            </span> &nbsp;
            <strong class="text-primary">{{ __('Collecting Analysis') }}...</strong>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-primary">
                    <tr>
                        <th>{{ __('Month') }}</th>
                        <th>{{ __('Total Carbon Reduction') }}</th>
                        <th>{{ __('Menu') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $months = $submission->competition->getMonthRange();
                    @endphp
                    @for ($m = 0; $m < $months->count(); $m++)
                        @if ($m == 0)
                            @continue
                        @endif
                        @php
                            $current_month = $months->get($m);
                            $last_month = $months->get($m - 1);
                        @endphp

                        <tr>
                            <td>{{ $last_month->getName() }}/{{ $current_month->getName() }}</td>
                            <td>{{ $calculation->total_carbon_reduction_each_month[$last_month->id . '|' . $current_month->id] }}
                                kgCO<sub>2</sub></td>
                            </th>
                            <td>
                                <div class="btn-toolbar justify-content-center" role="toolbar"
                                    aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="Action Button">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#viewMonthModal"
                                            wire:click.prevent='open({{ $last_month->id }}, {{ $current_month->id }})'>
                                            <i data-bs-toggle="tooltip"
                                                data-bs-title="{{ __('View Calculation for') }} {{ $last_month->getName() }}/{{ $current_month->getName() }}"
                                                data-feather="eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

    @endif

    <!-- View Month Modal -->
    <div class="modal fade" id="viewMonthModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewMonthModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewMonthModalLabel">{{ __('View Calculation for') }}
                        {{ $last_bill->month ? $last_bill->month->getName() : '' }}/{{ $current_bill->month ? $current_bill->month->getName() : '' }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="1">{{ __('Month') }}</th>
                                <td colspan="4" class="text-center">
                                    {{ $last_bill->month ? $last_bill->month->getName() : '' }}/{{ $current_bill->month ? $current_bill->month->getName() : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th colspan="5" class="h3 text-center">{{ __('Calculation Details') }}</th>
                            </tr>
                            <tr>
                                <th>{{ $current_bill->month ? $current_bill->month->getName() : '' }}</th>
                                <th></th>
                                <th>{{ $last_bill->month ? $last_bill->month->getName() : '' }}</th>
                                <th></th>
                                <th>{{ __('Carbon Reduction') }}</th>
                            </tr>
                            <tr>
                                <td>{{ $current_bill->calculation ? $current_bill->calculation->total_carbon_emission : '' }}
                                    kgCO<sub>2</sub></td>
                                <td>-</td>
                                <td>{{ $last_bill->calculation ? $last_bill->calculation->total_carbon_emission : '' }}
                                    kgCO<sub>2</sub></td>
                                <td>=</td>
                                <td>{{ $last_bill->id || $current_bill->id ? $calculation->total_carbon_reduction_each_month[$last_bill->month_id . '|' . $current_bill->month_id] : '' }}
                                    kgCO<sub>2</sub>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click.prevent="close()">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('initAsset', function() {
            activeFeatherIcon();
            activeTooltips();
        });

        document.addEventListener('livewire:load', function() {
            @this.calculate();
        });
    </script>
@endpush
