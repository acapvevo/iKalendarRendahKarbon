@push('styles')
@endpush

<div>
    <div class="py-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCommunityModal"
            wire:click.prevent='open'>
            {{ __('Register Community') }}
        </button>
    </div>
    <div class="table-resposive" wire:ignore>
        <table class="table table-bordered" id="tableCommunity">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Name/Username') }}</th>
                    <th>{{ __('Email Address') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Create Community Modal -->
    <div class="modal fade" id="createCommunityModal" tabindex="-1" aria-labelledby="createCommunityModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createCommunityModalLabel">{{ __('Register Community') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <form>

                        <div class="mb-3">
                            <label for="community.username" class="form-label">{{ __('Username') }}:</label>
                            <input type="text"
                                class="form-control {{ $errors->has('community.username') ? 'is-invalid' : '' }}"
                                placeholder="{{ __('Enter Community Username') }}" id="community.username" aria-label="username"
                                aria-describedby="username" wire:model.lazy="community.username" required>
                            @error('community.username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="community.email" class="form-label">{{ __('Email Address') }}:</label>
                            <input type="email"
                                class="form-control {{ $errors->has('community.email') ? 'is-invalid' : '' }}"
                                placeholder="{{ __('Enter Community Email Address') }}" id="community.email" aria-label="email"
                                aria-describedby="email" wire:model.lazy="community.email" required>
                            @error('community.email')
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
    <div class="modal fade" id="viewCommunityModal" tabindex="-1" aria-labelledby="viewCommunityModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewCommunityModalLabel">{{ __('View Community') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="w-25">{{ __('Name') }}</th>
                                    <td>{{ $community->name }}</td>
                                    <th class="w-25">{{ __('Identification Card Number') }}</th>
                                    <td>{{ $community->identification_number }}</td>
                                </tr>
                                <tr>
                                    <th class="w-25">{{ __('Phone Number') }}</th>
                                    <td>{{ $community->phone_number }}</td>
                                    <th class="w-25">{{ __('Email Address') }}</th>
                                    <td>{{ $community->email }}</td>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-center">{{ __('Occupation') }}</th>
                                </tr>
                                <tr>
                                    <th class="w-25">{{ __('Place') }}</th>
                                    <td colspan="3">{{ $occupation->position ?? __('Unemployed') }}</td>
                                </tr>
                                <tr>
                                    <th class="w-25">{{ __('Position') }}</th>
                                    <td>{{ $occupation->place ?? '' }}</td>
                                    <th class="w-25">{{ __('Sector') }}</th>
                                    <td>{{ strtoupper(__($occupation->getSector()->name ?? '')) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-center">{{ __('Address') }}</th>
                                </tr>
                                <tr>
                                    <th class="w-25">{{ __('Category') }}</th>
                                    <td colspan="3">{{ strtoupper(__($address->getCategory()->name ?? '')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w-25">{{ __('Address') }}</th>
                                    <td colspan="3">{{ $address->line_1 }}, <br>
                                        {{ $address->line_2 }}, <br>
                                        {!! $address->line_3 ? $address->line_3 . ', <br>' : '' !!}
                                        {{ $address->postcode }} {{ $address->city }}, <br>
                                        {{ $address->state }}, {{ $address->country }}</td>
                                </tr>
                                <tr>
                                    <th class="w-25">{{ __('Account Status') }}</th>
                                    <td colspan="3">
                                        {!! $community->isVerified
                                            ? '<i class="fa-solid fa-check" style="color: #00bd0d;"></i>'
                                            : '<i class="fa-solid fa-xmark" style="color: #ff0000;"></i>' !!}
                                        {{ $community->isVerified ? __('Verified') : __('Not Verified') }}
                                    </td>
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

    <!-- Edit Community Modal -->
    <div class="modal fade" id="editCommunityModal" tabindex="-1" aria-labelledby="editCommunityModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editCommunityModalLabel">{{ __('Edit Community') }}</h1>
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
                                <div class="col-lg-6 col-12">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('community.name') ? 'is-invalid' : '' }}"
                                        id="name" wire:model.lazy="community.name"
                                        placeholder="{{ __('Enter Community Name') }}"
                                        oninput="this.value = this.value.toUpperCase()">
                                    @error('community.name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label for="identification_number"
                                        class="form-label">{{ __('Identification Card Number') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('community.identification_number') ? 'is-invalid' : '' }}"
                                        id="identification_number" wire:model.lazy="community.identification_number"
                                        placeholder="{{ __('Enter Community Identification Card Number') }}">
                                    @error('community.identification_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-lg-6 col-12">
                                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                    <input type="email"
                                        class="form-control {{ $errors->has('community.email') ? 'is-invalid' : '' }}"
                                        id="email" wire:model.lazy="community.email" required
                                        placeholder="{{ __('Enter Community Email Address') }}">
                                    @error('community.email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                                    <div wire:ignore>
                                        <input type="text"
                                            class="form-control {{ $errors->has('community.phone_number') ? 'is-invalid' : '' }}"
                                            id="phone_number" wire:model.lazy="community.phone_number"
                                            placeholder="{{ __('Enter Community Phone Number') }}">
                                    </div>
                                    @error('community.phone_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Occupation -->
                        <div class="pt-3 pb-3">
                            <div class="h4 pb-2 mb-4 text-primary border-bottom border-primary">
                                {{ __('Occupation') }}
                                <small
                                    class="text-muted">({{ __('You can ignore this section if you not working') }})</small>
                            </div>

                            <div class="mb-3">
                                <label for="occupation.place"
                                    class="form-label">{{ __('Occupation Place') }}:</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('occupation.place') ? 'is-invalid' : '' }}"
                                    placeholder="{{ __('Enter Community Occuaption Place') }}" id="occupation.place"
                                    oninput="this.value = this.value.toUpperCase()" wire:model.lazy="occupation.place"
                                    aria-label="place" aria-describedby="place">
                                @error('occupation.place')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="occupation.position"
                                    class="form-label">{{ __('Occupation Position') }}:</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('occupation.position') ? 'is-invalid' : '' }}"
                                    placeholder="{{ __('Enter Community Occuaption Position') }}" id="occupation.position"
                                    oninput="this.value = this.value.toUpperCase()"
                                    wire:model.lazy="occupation.position" aria-label="position"
                                    aria-describedby="position">
                                @error('occupation.position')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="occupation.sector"
                                    class="form-label">{{ __('Occupation Sector') }}:</label>
                                <select
                                    class="form-select {{ $errors->has('occupation.sector') ? 'is-invalid' : '' }}"
                                    id="occupation.sector" wire:model="occupation.sector"
                                    aria-label="Default select example">
                                    <option value="" selected>{{ __('Choose Community Occuaption Sector') }}</option>
                                    @foreach (DB::table('occupation_sector_type')->get() as $sector)
                                        <option value="{{ $sector->code }}" wire:key="sector-{{ $sector->code }}">
                                            {{ strtoupper(__($sector->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('occupation.sector')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="pt-3 pb-3">
                            <div class="h4 pb-2 mb-4 text-primary border-bottom border-primary">
                                {{ __('Address') }}
                            </div>

                            <div class="mb-3">
                                <label for="address.category" class="form-label">{{ __('Category') }}:</label>
                                <select class="form-select {{ $errors->has('address.category') ? 'is-invalid' : '' }}"
                                    id="address.category" aria-label="Default select example"
                                    wire:model="address.category">
                                    <option selected value="">{{ __('Choose Community Address Category') }}</option>
                                    @foreach (DB::table('address_category')->get() as $category)
                                        <option value="{{ $category->code }}"
                                            wire:key="category-{{ $category->code }}">
                                            {{ strtoupper(__($category->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('address.category')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 row">
                                <div class="col-12 col-lg-4">
                                    <label for="address.line_1" class="form-label">{{ __('Address Line 1') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address.line_1') ? 'is-invalid' : '' }}"
                                        id="address.line_1" wire:model.lazy="address.line_1"
                                        placeholder="{{ __('Enter Community Address Line 1') }}">
                                    @error('address.line_1')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="address.line_2" class="form-label">{{ __('Address Line 2') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address.line_2') ? 'is-invalid' : '' }}"
                                        id="address.line_2" wire:model.lazy="address.line_2"
                                        placeholder="{{ __('Enter Community Address Line 2') }}">
                                    @error('address.line_2')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="address.line_3"
                                        class="form-label">{{ __('Address Line 3') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address.line_3') ? 'is-invalid' : '' }}"
                                        id="address.line_3" wire:model.lazy="address.line_3"
                                        placeholder="{{ __('Enter Community Address Line 3') }}">
                                    @error('address.line_3')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-12 col-lg-6">
                                    <label for="address.postcode" class="form-label">{{ __('Postcode') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address.postcode') ? 'is-invalid' : '' }}"
                                        id="address.postcode" wire:model.lazy="address.postcode"
                                        placeholder="{{ __('Enter Community Postcode') }}">
                                    @error('address.postcode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="address.city" class="form-label">{{ __('City') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address.city') ? 'is-invalid' : '' }}"
                                        id="address.city" wire:model.lazy="address.city"
                                        placeholder="{{ __('Enter Community City') }}">
                                    @error('address.city')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-12 col-lg-6">
                                    <label for="address.state" class="form-label">{{ __('State') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address.state') ? 'is-invalid' : '' }}"
                                        id="address.state" wire:model.lazy="address.state"
                                        placeholder="{{ __('Enter Community State') }}" readonly>
                                    @error('address.state')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="address.country" class="form-label">{{ __('Country') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address.country') ? 'is-invalid' : '' }}"
                                        id="address.country" wire:model.lazy="address.country"
                                        placeholder="{{ __('Enter Community Country') }}" readonly>
                                    @error('address.country')
                                        <div class="invalid-feedback">
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
    <script>
        $('document').ready(function() {
            $('#tableCommunity').DataTable({
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                ajax: {
                    "type": "GET",
                    "url": "{{ route('admin.participant.community.filter') }}",
                },
                searchBuilder: {
                    columns: [1, 2, 3]
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
                    targets: [0, 1, 2, 3]
                }, {
                    type: 'unknownType',
                    targets: [2]
                }],
                columns: [{
                        "width": "40%"
                    },
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
