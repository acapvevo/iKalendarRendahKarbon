@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

<div>
    <div class="py-3 d-flex justify-content-end">
        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
            data-bs-target="#addSubmissionModal">{{ __('Add Submission') }}</button>
    </div>
    <div class="table-resposive" wire:ignore>
        <table class="table table-bordered" id="tableSubmission" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- View Submission Modal -->
    <div class="modal fade" id="viewSubmissionModal" tabindex="-1" aria-labelledby="viewSubmissionModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewSubmissionModalLabel">{{ __('View Submission') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w-25">{{ __('Name') }}</th>
                                <td>{{ $submission->community->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Zone') }}</th>
                                <td>{{ $submission && $submission->community && $submission->community->address->zone ? $submission->community->address->zone->getFormalName() : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Total Carbon Emission') }}</th>
                                <td>{!! $submission ? $submission->getTotalCarbonEmission() : '' !!}</td>
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

    <!-- Add Submission Modal -->
    <div class="modal fade" id="addSubmissionModal" tabindex="-1" aria-labelledby="addSubmissionModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addSubmissionModalLabel">{{ __('Add Submission') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="input_file_label" class="form-label">{{ __('Residents') }}</label>
                            <div wire:ignore>
                                <select
                                    class="form-select {{ $errors->has('community_selection') ? 'is-invalid' : '' }}"
                                    id="addSubmission" multiple wire:model='community_selection'
                                    data-placeholder="{{ __('Choose Resident(s) to be registered for') }} {{ $competition->name }}">
                                </select>
                            </div>
                            @error('community_selection')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"
                        wire:click.prevent="add">
                        <span wire:loading.remove>{{ __('Add') }}</span>
                        <div wire:loading wire:target="add">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Adding...') }}
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="{{ asset('js/modal.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/{{ LaravelLocalization::getCurrentLocale() }}.min.js">
    </script>
    <script src="{{ asset('js/select2/helper.js') }}"></script>

    <script>
        $('document').ready(function() {
            $('#tableSubmission').DataTable({
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                ajax: {
                    "type": "GET",
                    "url": "{{ route('resident.contest.submission.filter', ['competition_id' => $competition_id]) }}",
                },
                searchBuilder: {
                    columns: [0, 1, 2]
                },
                buttons: [
                    'searchBuilder',
                    {
                        extend: 'spacer',
                    },
                    'pageLength'
                ],
                columnDefs: [{
                    className: "dt-center",
                    targets: '_all'
                }, {
                    type: 'unknownType',
                    targets: [1]
                }],
                columns: [{
                        "width": "40%"
                    },
                    null,
                    null
                ],
                "drawCallback": function(settings) {
                    activeFeatherIcon();
                    activeTooltips();
                    registerLivewireEventListener();
                }
            });

            closeModal('viewSubmissionModal');

            initSelectionCommunity('#addSubmission', '#addSubmissionModal',
                '{{ route('resident.contest.submission.select', ['competition_id' => $competition_id]) }}',
                "{{ LaravelLocalization::getCurrentLocale() }}",
                function(e) {
                    const selection = $('#addSubmission').select2('data').map(function(community) {
                        return community.id;
                    });
                    @this.set('community_selection', selection);
                });
        });

        function registerLivewireEventListener() {
            const openModalBtnList = document.querySelectorAll('.openModal');
            openModalBtnList.forEach(function(openModalBtn) {
                openModalBtn.addEventListener('click', function(e) {
                    Livewire.emit('openModal', openModalBtn.id);
                });
            });

            const viewSubmissionBtnList = document.querySelectorAll('.viewSubmission');
            viewSubmissionBtnList.forEach(function(viewSubmissionBtn) {
                viewSubmissionBtn.addEventListener('click', function(e) {
                    Livewire.emit('viewSubmission', viewSubmissionBtn.id);
                });
            });
        }
    </script>
@endpush
