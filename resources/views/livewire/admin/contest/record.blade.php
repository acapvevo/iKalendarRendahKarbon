@push('styles')
@endpush

<div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered text-center">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Month') }}</th>
                    <th>{{ __('Total Carbon Emission') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submission->competition->months as $monthObj)
                    <tr>
                        <td>{{ $monthObj->getName() }}</td>
                        <td>{{ $submission->getTotalCarbonEmissionByMonthID($monthObj->id) }} kgCO<sub>2</sub></td>
                        <td>
                            <div class="btn-toolbar justify-content-center" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewMonthModal" wire:click.prevent='open({{ $monthObj->id }})'>
                                        <i data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('View Submission for') }} {{ $monthObj->getName() }}"
                                            data-feather="eye"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- View Month Modal -->
    <div class="modal fade" id="viewMonthModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewMonthModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewMonthModalLabel">{{ __('View Submission for') }}
                        {{ $month ? $month->getName() : '' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="1">{{ __('Month') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ $month ? $month->getName() : '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="4" class="h3 text-center">{{ __('Submission Details') }}</th>
                            </tr>
                            <tr>
                                <th colspan="4" class="h3 text-center">{{ __('Electric') }}</th>
                            </tr>
                            <tr>
                                <th style="width: 20%">{{ __('Usage') }}</th>
                                <td class="text-center">{{ number_format((float) $electric->usage ?? 0, 2) }} kWh</td>
                                <th style="width: 20%">{{ __('Bill Charge') }}</th>
                                <td class="text-center">RM {{ number_format((float) $electric->charge ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Evidence') }}</th>
                                <td colspan="3" class="text-center">
                                    @if ($electric->evidence ?? null)
                                        <form action="{{ route('admin.contest.submission.download') }}"
                                            method="post" target="_blank">
                                            @csrf

                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                            <button type="submit" class="btn btn-link" name="type"
                                                value="electric">{{ $electric->evidence }}</button>
                                        </form>
                                    @else
                                        {{ __('No Evidence') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Carbon Emission') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ number_format((float) $electric->carbon_emission ?? 0, 2) }}
                                    kgCO<sub>2</sub></td>
                            </tr>
                            <tr>
                                <th colspan="4" class="h3 text-center">{{ __('Water') }}</th>
                            </tr>
                            <tr>
                                <th style="width: 20%">{{ __('Usage') }}</th>
                                <td class="text-center">{{ number_format((float) $water->usage ?? 0, 2) }}
                                    m<sup>3</sup>
                                </td>
                                <th style="width: 20%">{{ __('Bill Charge') }}</th>
                                <td class="text-center">RM {{ number_format((float) $water->charge ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Evidence') }}</th>
                                <td colspan="3" class="text-center">
                                    @if ($water->evidence ?? null)
                                        <form action="{{ route('admin.contest.submission.download') }}"
                                            method="post" target="_blank">
                                            @csrf

                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                            <button type="submit" class="btn btn-link" name="type"
                                                value="water">{{ $water->evidence }}</button>
                                        </form>
                                    @else
                                        {{ __('No Evidence') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Carbon Emission') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ number_format((float) $water->carbon_emission ?? 0, 2) }}
                                    kgCO<sub>2</sub></td>
                            </tr>
                            <tr>
                                <th colspan="4" class="h3 text-center">{{ __('Recycle') }}</th>
                            </tr>
                            <tr>
                                <th style="width: 20%">{{ __('Total Weight') }}</th>
                                <td class="text-center">{{ number_format((float) $recycle->weight ?? 0, 2) }} kg</td>
                                <th style="width: 20%">{{ __('Total Sell Value') }}</th>
                                <td class="text-center">RM {{ number_format((float) $recycle->value ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Evidence') }}</th>
                                <td colspan="3" class="text-center">
                                    @if ($recycle->evidence ?? null)
                                        <form action="{{ route('admin.contest.submission.download') }}"
                                            method="post" target="_blank">
                                            @csrf

                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                            <button type="submit" class="btn btn-link" name="type"
                                                value="recycle">{{ $recycle->evidence }}</button>
                                        </form>
                                    @else
                                        {{ __('No Evidence') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Carbon Emission') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ number_format((float) $recycle->carbon_emission ?? 0, 2) }}
                                    kgCO<sub>2</sub></td>
                            </tr>
                            <tr>
                                <th colspan="4" class="h3 text-center">{{ __('Used Oil') }}</th>
                            </tr>
                            <tr>
                                <th style="width: 20%">{{ __('Total Weight') }}</th>
                                <td class="text-center">{{ number_format((float) $used_oil->weight ?? 0, 2) }} kg</td>
                                <th style="width: 20%">{{ __('Total Sell Value') }}</th>
                                <td class="text-center">RM {{ number_format((float) $used_oil->value ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Evidence') }}</th>
                                <td colspan="3" class="text-center">
                                    @if ($used_oil->evidence ?? null)
                                        <form action="{{ route('admin.contest.submission.download') }}"
                                            method="post" target="_blank">
                                            @csrf

                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                            <button type="submit" class="btn btn-link" name="type"
                                                value="used_oil">{{ $used_oil->evidence }}</button>
                                        </form>
                                    @else
                                        {{ __('No Evidence') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1">{{ __('Carbon Emission') }}</th>
                                <td colspan="3" class="text-center">
                                    {{ number_format($used_oil->carbon_emission ?? 0, 2) }}
                                    kgCO<sub>2</sub></td>
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
    </script>
@endpush
