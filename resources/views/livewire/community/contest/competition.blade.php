@push('styles')
@endpush

<div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered" id="competitionTable" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Competition') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($competitions as $competition)
                    <tr>
                        <td>{{ $competition->name }}</td>
                        <td>{{ $competition->checkSubmissionStatus() }}</td>
                        <td>
                            <div class="justify-content-center">
                                <div class="btn-group-vertical d-lg-none" role="group"
                                    aria-label="Vertical button group">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewCompetitionModal"
                                        wire:click.prevent='open({{ $competition->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Competition') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click='view({{ $competition->id }})' name="competition_id"><i
                                            data-bs-toggle="tooltip" data-bs-title="{{ __('View Submission') }}"
                                            data-feather="file-text"></i></button>
                                </div>
                                <div class="btn-group d-none d-lg-inline-flex" role="group"
                                    aria-label="Horizontal button group">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewCompetitionModal"
                                        wire:click.prevent='open({{ $competition->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Competition') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click='view({{ $competition->id }})' name="competition_id"><i
                                            data-bs-toggle="tooltip" data-bs-title="{{ __('View Submission') }}"
                                            data-feather="file-text"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- View Competition Modal -->
    <div class="modal fade" id="viewCompetitionModal" tabindex="-1" aria-labelledby="viewCompetitionModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewCompetitionModalLabel">{{ __('View Competition') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <td>{{ $competition->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Status') }}</th>
                                <td>{{ $submission ? $submission->checkBillsSubmit() : __('Not Submitted') }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="h3 text-center">{{ __('Submission Statistic') }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Total Carbon Emission') }}</th>
                                <td>
                                    @if ($submission)
                                        {{ $submission->total_carbon_emission }} KgCO<sub>2</sub>
                                    @else
                                        0 KgCO<sub>2</sub>
                                    @endif
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#competitionTable').DataTable({
                columnDefs: [{
                    targets: '_all',
                    className: 'dt-center'
                }]
            });
        });
    </script>
@endpush
