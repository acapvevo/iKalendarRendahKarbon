@push('styles')
@endpush

<div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered" id="competitionTable">
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
                        <td>{{ $competition->checkSubmissionStatus(Auth::user()->id) }}</td>
                        <td>
                            <div class="btn-toolbar justify-content-center" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewCompetitionModal"
                                        wire:click.prevent='open({{ $competition->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Competition') }}"
                                            data-feather="eye"></i>
                                    </button>
                                </div>
                                <div class="ps-3 btn-group" role="group" aria-label="Question">
                                    <form action="{{ route('community.contest.submission.list', ['competition_id' => $competition->id]) }}" method="post">
                                        @csrf

                                        <button type="submit" data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('View Submission') }}" class="btn btn-primary btn-sm"
                                            value="{{ $competition->id }}" name="competition_id"><i
                                                class="fa-solid fa-file-lines"></i></button>
                                    </form>
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
                                    {{ $submission->totalCarbonEmission }} KgCO<sub>2</sub>
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
