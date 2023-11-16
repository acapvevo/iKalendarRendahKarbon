@push('styles')
@endpush

<div>
    <div class="table-resposive" wire:ignore>
        <table class="table table-bordered" id="tableSubmission" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Zone') }}</th>
                    <th>{{ __('Total Carbon Emission') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- View Competition Modal -->
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

</div>

@push('scripts')
    <script src="{{ asset('js/modal.js') }}"></script>

    <script>
        $('document').ready(function() {
            $('#tableSubmission').DataTable({
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                ajax: {
                    "type": "GET",
                    "url": "{{ route('admin.contest.submission.filter', ['competition_id' => $competition_id]) }}",
                },
                searchBuilder: {
                    columns: [0, 1, 2, 3]
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
                    targets: [0, 1, 2, 3, 4]
                }, {
                    type: 'unknownType',
                    targets: [3]
                }],
                columns: [{
                        "width": "40%"
                    },
                    null,
                    null,
                    null,
                    null
                ],
                "drawCallback": function(settings) {
                    activeFeatherIcon();
                    activeTooltips();
                    registerOpenModalEventListener();
                }
            });

            closeModal('viewSubmissionModal');
        });

        function registerOpenModalEventListener() {
            const openModalBtnList = document.querySelectorAll('.openModal');
            openModalBtnList.forEach(function(openModalBtn) {
                openModalBtn.addEventListener('click', function(e) {
                    Livewire.emit('openModal', openModalBtn.id);
                });
            })
        }
    </script>
@endpush
