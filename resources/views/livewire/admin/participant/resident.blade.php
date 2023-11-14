@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    @laravelTelInputStyles
@endpush

<div>
    <div class="py-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createResidentModal"
            wire:click.prevent='open'>
            {{ __('Register Community') }}
        </button>
    </div>
    <div class="table-resposive" wire:ignore>
        <table class="table table-bordered" id="tableResident" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Name/Username') }}</th>
                    <th>{{ __('Email Address') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Create Resident Modal -->
    <div class="modal fade" id="createResidentModal" tabindex="-1" aria-labelledby="createResidentModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createResidentModalLabel">{{ __('Register Community') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <form>

                        <div class="mb-3">
                            <label for="resident_username" class="form-label">{{ __('Username') }}:</label>
                            <input type="text"
                                class="form-control {{ $errors->has('resident.username') ? 'is-invalid' : '' }}"
                                placeholder="{{ __('Enter Community Username') }}" id="resident_username"
                                aria-label="username" aria-describedby="username" wire:model.lazy="resident.username"
                                required>
                            @error('resident.username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="resident_email" class="form-label">{{ __('Email Address') }}:</label>
                            <input type="email"
                                class="form-control {{ $errors->has('resident.email') ? 'is-invalid' : '' }}"
                                placeholder="{{ __('Enter Community Email Address') }}" id="resident_email"
                                aria-label="email" aria-describedby="email" wire:model.lazy="resident.email" required>
                            @error('resident.email')
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
                    <button class="btn btn-primary" type="button" wire:loading.attr="disabled"
                        wire:click.prevent="create()">
                        <span wire:loading.remove>{{ __('Save') }}</span>
                        <div wire:loading wire:target="create">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Saving...') }}
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Community Modal -->
    <div class="modal fade" id="viewResidentModal" tabindex="-1" aria-labelledby="viewResidentModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewResidentModalLabel">{{ __('View Community') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="w-25">{{ __('Name') }}</th>
                                    <td colspan="3">{{ $resident->name }}</td>
                                </tr>
                                <tr>
                                    <th class="w-25">{{ __('Email Address') }}</th>
                                    <td>{{ $resident->email }}</td>
                                    <th class="w-25">{{ __('Phone Number') }}</th>
                                    <td>{{ $resident->phone_number }}</td>
                                </tr>
                            </tbody>
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

    <!-- Edit Resident Modal -->
    <div class="modal fade" id="editResidentModal" tabindex="-1" aria-labelledby="editResidentModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editResidentModalLabel">{{ __('Edit Community') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <form id="updateUserForm">

                        <!-- Profile -->
                        <div class="pt-3 pb-3">
                            <div class="h4 pb-2 mb-4 text-primary border-bottom border-primary">
                                {{ __('Profile') }}
                            </div>

                            <div class="mb-3 row">
                                <div class="col-lg-12 col-12">
                                    <label for="resident_name" class="form-label">{{ __('Name') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('resident.name') ? 'is-invalid' : '' }}"
                                        id="resident_name" wire:model.lazy="resident.name"
                                        placeholder="{{ __('Enter Community Name') }}"
                                        oninput="this.value = this.value.toUpperCase()">
                                    @error('resident.name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-lg-6 col-12">
                                    <label for="resident_email" class="form-label">{{ __('Email Address') }}</label>
                                    <input type="email"
                                        class="form-control {{ $errors->has('resident.email') ? 'is-invalid' : '' }}"
                                        id="resident_email" wire:model.lazy="resident.email" required
                                        placeholder="{{ __('Enter Community Email Address') }}">
                                    @error('resident.email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label for="resident_phone_number"
                                        class="form-label">{{ __('Phone Number') }}</label>
                                    <x-tel-input wire:model="resident.phone_number" id="resident_phone_number"
                                        class="form-control"
                                        placeholder="{{ __('Enter Community Phone Number') }}" />
                                    @error('resident.phone_number')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click.prevent="close()">{{ __('Close') }}</button>
                    <button class="btn btn-primary" type="button" wire:loading.attr="disabled"
                        wire:click.prevent="update()">
                        <span wire:loading.remove>{{ __('Update') }}</span>
                        <div wire:loading wire:target="update">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Updating...') }}
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    @laravelTelInputScripts
    <script src="{{asset('js/intl-tel-input/helpers.js')}}"></script>

    <script>
        $('document').ready(function() {
            $('#tableResident').DataTable({
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                ajax: {
                    "type": "GET",
                    "url": "{{ route('admin.participant.resident.filter') }}",
                },
                searchBuilder: {
                    columns: [0, 1]
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
                    registerOpenModalEventListener();
                }
            });
        });

        function registerOpenModalEventListener() {
            const openModalBtnList = document.querySelectorAll('.openModal');
            openModalBtnList.forEach(function(openModalBtn) {
                openModalBtn.addEventListener('click', function(e) {
                    Livewire.emit('openModal', openModalBtn.id);
                });
            });

            const viewCommunityBtnList = document.querySelectorAll('.viewCommunity');
            viewCommunityBtnList.forEach(function(viewCommunityBtn) {
                viewCommunityBtn.addEventListener('click', function(e) {
                    Livewire.emit('viewCommunity', viewCommunityBtn.id);
                });
            });
        }

        document.addEventListener('initTelInput', event => {
            initTelInput('resident_phone_number');
        })

        closeModal('editResidentModal');
        closeModal('viewResidentModal');
    </script>
@endpush
