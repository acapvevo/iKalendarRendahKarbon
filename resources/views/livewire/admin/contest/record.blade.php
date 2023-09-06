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
    <div class="modal fade" id="viewMonthModal" tabindex="-1" aria-labelledby="viewMonthModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewMonthModalLabel">{{ __('View Submission for') }}
                        {{ $month ? $month->getName() : '' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

                            @foreach ($submission_categories as $category)
                                <tr>
                                    <th colspan="4" class="h3 text-center">{{ __($category->description) }}</th>
                                </tr>
                                @switch($category->name)
                                    @case('electric')
                                    @case('water')
                                        <tr>
                                            <th style="width: 20%">{{ __('Usage') }}</th>
                                            <td class="text-center">
                                                {{ number_format((float) ${$category->name}->usage ?? 0, 2) }}
                                                {!! $category->symbol !!}
                                            </td>
                                            <th style="width: 20%">{{ __('Bill Charge') }}</th>
                                            <td class="text-center">RM
                                                {{ number_format((float) ${$category->name}->charge ?? 0, 2) }}
                                            </td>
                                        </tr>
                                    @break

                                    @case('recycle')
                                    @case('used_oil')
                                        <tr>
                                            <th style="width: 20%">{{ __('Total Weight') }}</th>
                                            <td class="text-center">
                                                {{ number_format((float) ${$category->name}->weight ?? 0, 2) }}
                                                {!! $category->symbol !!}
                                            </td>
                                            <th style="width: 20%">{{ __('Total Sell Value') }}</th>
                                            <td class="text-center">RM
                                                {{ number_format((float) ${$category->name}->value ?? 0, 2) }}
                                            </td>
                                        </tr>
                                    @break

                                    @default
                                @endswitch
                                <tr>
                                    <th colspan="1">{{ __('Carbon Emission') }}</th>
                                    <td colspan="3" class="text-center">
                                        {{ number_format((float) ${$category->name}->carbon_emission ?? 0, 2) }}
                                        kgCO<sub>2</sub></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        const viewMonthModalEl = document.getElementById('viewMonthModal')
        viewMonthModalEl.addEventListener('hidden.bs.modal', event => {
            @this.emit('closeModal')
        })
    </script>
@endpush
