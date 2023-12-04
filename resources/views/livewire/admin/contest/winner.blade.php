@push('styles')
@endpush

<div>
    <div class="py-3 row">
        <div class="col-lg-4 ms-auto">
            <div class="row">
                <div class="col-2 d-flex justify-content-end">
                    <label for="month_select" class="col-form-label">{{ __('Category') }}:</label>
                </div>
                <div class="col-10 d-flex align-items-center">
                    <select class="form-select {{ $errors->has('address_category_code') ? 'is-invalid' : '' }}"
                        id="address_category_code_select" style="width: 100%" wire:model='address_category_code'>
                        @foreach ($address_category_list as $category)
                            <option value="{{ $category->code }}">{{ __($category->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error('address_category_code')
                <div class="invalid-message">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div wire:ignore class="table-resposive">
        <table class="table table-bordered text-center align-middle" id="tableSubmission" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th style="width: 5%">{{ __('Rank') }}</th>
                    <th style="width: 40%">{{ __('Name') }}</th>
                    <th>{{ __('Total Carbon Reduction') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submissions as $s => $submissionObj)
                    <tr>
                        <td>{{ $s + 1 }}</td>
                        <td>{{ $submissionObj->community->name ?? $submissionObj->community->username }}</td>
                        <td>{{ abs($submissionObj->calculation->total_carbon_reduction) }} kgCO<sub>2</sub></td>
                        <td>
                            <div class="justify-content-center">
                                <div class="btn-group-vertical d-lg-none" role="group"
                                    aria-label="Vertical button group">
                                    <button type="button" class="btn btn-primary btn-sm openModal"
                                        wire:click='open({{ $submissionObj->id }})' data-bs-toggle="modal"
                                        data-bs-target="#viewSubmissionModal">
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Submission') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm viewSubmission"
                                        wire:click='view({{ $submissionObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Record and Answer') }}"
                                            data-feather="file-text"></i>
                                    </button>
                                </div>
                                <div class="btn-group d-none d-lg-inline-flex" role="group"
                                    aria-label="Horizontal button group">
                                    <button type="button" class="btn btn-primary btn-sm openModal"
                                        wire:click='open({{ $submissionObj->id }})' data-bs-toggle="modal"
                                        data-bs-target="#viewSubmissionModal">
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Submission') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm viewSubmission"
                                        wire:click='view({{ $submissionObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Record and Answer') }}"
                                            data-feather="file-text"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
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
                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Getting Data') }}...</strong>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="w-25">{{ __('Name') }}/{{ __('Username') }}</th>
                                    <td>{{ $submission && $submission->community ? $submission->community->name ?? $submission->community->username : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w-25">{{ __('Phone Number') }}</th>
                                    <td>{{ $submission && $submission->community ? $submission->community->getPhoneNumber() : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w-25">{{ __('Address') }}</th>
                                    <td>{{ $submission && $submission->community ? $submission->community->address->getFullAddressInSingleLine() : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Zone') }}</th>
                                    <td>{{ $submission && $submission->community && $submission->community->address->zone ? $submission->community->address->zone->getFormalName() : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Total Carbon Reduction') }}</th>
                                    <td>{{ $submission && $submission->community ? abs($submission->calculation->total_carbon_reduction) : '' }}
                                        kgCO<sub>2</sub></td>
                                </tr>
                            </table>
                        </div>
                    @endif
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
        closeModal('viewSubmissionModal');
        const option = {
            columnDefs: [{
                type: 'natural',
                targets: 2
            }]
        };

        $('document').ready(function() {

            $('#tableSubmission').DataTable(option);

            const address_category_select = document.getElementById('address_category_code_select');
            address_category_select.addEventListener('change', function() {
                showLoadingModal();
                Livewire.emit('changeCategory');
            })

            document.addEventListener("updateTable", (event) => {
                const submissions = event.detail.submissions;

                $('#tableSubmission').DataTable().destroy();

                let stringHTML = '';
                for (let s in submissions) {
                    stringHTML += `
                    <tr>
                        <td>` + (parseInt(s) + 1) + `</td>
                        <td>` + (submissions[s]['community']['name'] ? submissions[s]['community']['name'] :
                            submissions[s]['community']['username']) + `</td>
                        <td>` + Math.abs(submissions[s]['calculation']['total_carbon_reduction']) + ` kgCO<sub>2</sub></td>
                        <td>
                            <div class="justify-content-center">
                                <div class="btn-group-vertical d-lg-none" role="group"
                                    aria-label="Vertical button group">
                                    <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                        data-bs-target="#viewSubmissionModal" id='` + submissions[s]['id'] + `'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Submission') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm viewSubmission" id='` +
                        submissions[s]['id'] + `'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Record and Answer') }}"
                                            data-feather="file-text"></i>
                                    </button>
                                </div>
                                <div class="btn-group d-none d-lg-inline-flex" role="group"
                                    aria-label="Horizontal button group">
                                    <button type="button" class="btn btn-primary btn-sm openModal" data-bs-toggle="modal"
                                        data-bs-target="#viewSubmissionModal" id='` + submissions[s]['id'] + `'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Submission') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm viewSubmission" id='` +
                        submissions[s]['id'] + `'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Record and Answer') }}"
                                            data-feather="file-text"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    `
                }

                $('#tableSubmission tbody').html(stringHTML);
                $('#tableSubmission').DataTable(option);

                activeFeatherIcon();
                activeTooltips();
                registerButtonEventListener();

                hideLoadingModal();
            });
        });

        function registerButtonEventListener() {
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
