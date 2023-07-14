<div>
    <div class="pt-3 pb-3 d-flex justify-content-end align-items-middle">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCompetitionModal"
            wire:click.prevent='open()'>
            {{ __('Create Competition') }}
        </button>
    </div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered" id="competitionTable">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Competition') }}</th>
                    <th>{{ __('Year') }}</th>
                    <th>{{ __('Total Questions') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($competitions as $competition)
                    <tr>
                        <td>{{ $competition->name }}</td>
                        <td>{{ $competition->year }}</td>
                        <td>{{ $competition->questions->count() }}</td>
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
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#updateCompetitionModal"
                                        wire:click.prevent='open({{ $competition->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('Update Competition') }}"
                                            data-feather="edit-2"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click.prevent='askDelete({{ $competition->id }})'><i data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('Delete Competition') }}"
                                            data-feather="trash-2"></i></button>
                                </div>
                                <div class="ps-3 btn-group" role="group" aria-label="Question">
                                    <form action="{{ route('admin.contest.question.list') }}" method="post">
                                        @csrf

                                        <button type="submit" data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('View Questions') }}" class="btn btn-primary btn-sm"
                                            value="{{ $competition->id }}" name="competition_id"><i
                                                class="fa-solid fa-clipboard-question"></i></button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Competition Modal -->
    <div class="modal fade" id="createCompetitionModal" tabindex="-1" aria-labelledby="createCompetitionModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createCompetitionModalLabel">{{ __('Create Competition') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <form id="createCompetitionForm">

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('competition.name') ? 'is-invalid' : '' }}"
                                id="name" wire:model.lazy="competition.name"
                                placeholder="{{ __('Enter Competition Name') }}" required>
                            @error('competition.name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label">{{ __('Year') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('competition.year') ? 'is-invalid' : '' }}"
                                id="year" wire:model.lazy="competition.year"
                                placeholder="{{ __('Enter Competition Year') }} (XXXX)" required>
                            @error('competition.year')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click.prevent="close()">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        wire:click.prevent="create()">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
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
                                <th>{{ __('Year') }}</th>
                                <td>{{ $competition->year }}</td>
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

    <!-- Update Competition Modal -->
    <div class="modal fade" id="updateCompetitionModal" tabindex="-1" aria-labelledby="updateCompetitionModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateCompetitionModalLabel">{{ __('Update Competition') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <form id="updateCompetitionForm">

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('competition.name') ? 'is-invalid' : '' }}"
                                id="name" wire:model.lazy="competition.name"
                                placeholder="{{ __('Enter Competition Name') }}" required>
                            @error('competition.name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label">{{ __('Year') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('competition.year') ? 'is-invalid' : '' }}"
                                id="year" wire:model.lazy="competition.year"
                                placeholder="{{ __('Enter Competition Year') }} (XXXX)" required>
                            @error('competition.year')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click.prevent="close()">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        wire:click.prevent="update()">{{ __('Update') }}</button>
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
