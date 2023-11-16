@push('styles')
@endpush

<div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered" id="competitionTable" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Competition') }}</th>
                    <th>{{ __('No. of Submissions') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($competitions as $competitionObj)
                    <tr>
                        <td>{{ $competitionObj->name }}</td>
                        <td>{{ $competitionObj->getSubmissionsByResident(request()->user()->id)->count() }}</td>
                        <td>
                            <div class="justify-content-center">
                                <div class="btn-group-vertical d-lg-none" role="group"
                                    aria-label="Vertical button group">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewCompetitionModal"
                                        wire:click.prevent='open({{ $competitionObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Competition') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click='view({{ $competitionObj->id }})'><i data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('View Submissions') }}"
                                            data-feather="file-text"></i></button>
                                </div>
                                <div class="btn-group d-none d-lg-inline-flex" role="group"
                                    aria-label="Horizontal button group">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewCompetitionModal"
                                        wire:click.prevent='open({{ $competitionObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Competition') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click='view({{ $competitionObj->id }})'><i data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('View Submissions') }}" data-feather="file-text"></i>
                                    </button>
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
                                <td>{{ $competition->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('No. of Submissions') }}</th>
                                <td>{{ $competition ? $competition->getSubmissionsByResident(request()->user()->id)->count() : 0 }}
                                    {{ __('Submissions') }}</td>
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
    <script src="{{ asset('js/modal.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#competitionTable').DataTable({
                columnDefs: [{
                    targets: '_all',
                    className: 'dt-center'
                }]
            });
        });

        closeModal('viewCompetitionModal');
    </script>
@endpush
