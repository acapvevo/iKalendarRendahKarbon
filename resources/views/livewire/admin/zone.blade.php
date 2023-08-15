@push('styles')
@endpush
<div>
    <div class="py-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createZoneModal">
            {{ __('Create Zone') }}
        </button>
    </div>
    <div wire:ignore class="table-responsive">
        <table class="table table-bordered" style="width: 100%" id="zoneTable">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Number') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $zoneObj)
                    <tr>
                        <td>{{ $zoneObj->number }}</td>
                        <td>{{ $zoneObj->name }}</td>
                        <td>
                            <div class="btn-toolbar justify-content-center" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewZoneModal" wire:click.prevent='open({{ $zoneObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Zone') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#updateZoneModal"
                                        wire:click.prevent='open({{ $zoneObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('Update Zone') }}"
                                            data-feather="edit-2"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click.prevent='askDelete({{ $zoneObj->id }})'><i data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('Delete Zone') }}" data-feather="trash-2"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Zone Modal -->
    <div wire:ignore.self class="modal fade" id="createZoneModal" tabindex="-1" aria-labelledby="createZoneModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createZoneModalLabel">{{ __('Create Zone') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="mb-3 row">
                            <div class="col-lg-3">
                                <label for="number" class="form-label">{{ __('Number') }}</label>
                                <input type="number"
                                    class="form-control {{ $errors->has('zone.number') ? 'is-invalid' : '' }}"
                                    id="number" wire:model.lazy="zone.number"
                                    placeholder="{{ __('Insert Zone Number') }}" required>
                                @error('zone.number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-9">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('zone.name') ? 'is-invalid' : '' }}"
                                    id="name" wire:model.lazy="zone.name"
                                    oninput="this.value = this.value.toUpperCase()"
                                    placeholder="{{ __('Insert Zone Name') }}" required>
                                @error('zone.name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="coordinates" class="form-label">{{ __('Coordinates') }} <span
                                    class="text-muted">Ex.:
                                    {{ __('Latitude') }},{{ __('Longitude') }}</span>
                            </label>
                            <div id="coordinates">
                                @foreach ($coordinates as $i => $coordinate)
                                    <div class="row py-2">
                                        <div class="col-lg-10">
                                            <input
                                                class="form-control {{ $errors->has('coordinates.' . $i) ? 'is-invalid' : '' }}"
                                                type="text" wire:model.lazy="coordinates.{{ $i }}"
                                                placeholder="{{ __('Insert Zone Coordinate') }} {{ $i + 1 }}">
                                            @error('coordinates.' . $i)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-2 d-flex justify-content-center">
                                            <button class="btn btn-danger"
                                                wire:click.prevent="removeCoordinate({{ $i }})">{{ __('Remove') }}</button>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="py-3 d-flex justify-content-center">
                                    <button class="btn btn-success"
                                        wire:click.prevent="addCoordinate">{{ __('Add') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button class="btn btn-primary" type="button" wire:loading.attr="disabled"
                        wire:click.prevent="create">
                        <span wire:loading.remove>{{ __('Save') }}</span>
                        <div wire:loading>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Saving...') }}
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Zone Modal -->
    <div wire:ignore.self class="modal fade" id="viewZoneModal" tabindex="-1" aria-labelledby="viewZoneModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewZoneModalLabel">{{ __('View Zone') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Collecting Zone Data') }}...</strong>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="w-25">{{ __('Number') }}</th>
                                    <td colspan="2">{{ $zone->number }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <td colspan="2">{{ $zone->name }}</td>
                                </tr>
                                @foreach ($zone->coordinates ?? [] as $index => $coordinate)
                                    <tr>
                                        @if ($index == 0)
                                            <th rowspan="{{ $zone->coordinates->count() + 1 }}">
                                                {{ __('Coordinates') }}
                                            </th>
                                            <th class="text-center">{{ __('Latitude') }}</th>
                                            <th class="text-center">{{ __('Longitude') }}</th>
                                        @else
                                            <td class="text-center">{{ $coordinate['lat'] }}</td>
                                            <td class="text-center">{{ $coordinate['lng'] }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Zone Modal -->
    <div wire:ignore.self class="modal fade" id="updateZoneModal" tabindex="-1"
        aria-labelledby="updateZoneModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateZoneModalLabel">{{ __('Update Zone') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Collecting Zone Data') }}...</strong>
                        </div>
                    @else
                        <form>
                            <div class="mb-3 row">
                                <div class="col-lg-3">
                                    <label for="number" class="form-label">{{ __('Number') }}</label>
                                    <input type="number"
                                        class="form-control {{ $errors->has('zone.number') ? 'is-invalid' : '' }}"
                                        id="number" wire:model.lazy="zone.number"
                                        placeholder="{{ __('Insert Zone Number') }}" required>
                                    @error('zone.number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-9">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('zone.name') ? 'is-invalid' : '' }}"
                                        id="name" wire:model.lazy="zone.name"
                                        oninput="this.value = this.value.toUpperCase()"
                                        placeholder="{{ __('Insert Zone Name') }}" required>
                                    @error('zone.name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="coordinates" class="form-label">{{ __('Coordinates') }} <span
                                        class="text-muted">Ex.:
                                        {{ __('Latitude') }},{{ __('Longitude') }}</span>
                                </label>
                                <div id="coordinates">
                                    @foreach ($coordinates as $i => $coordinate)
                                        <div class="row py-2">
                                            <div class="col-lg-10">
                                                <input
                                                    class="form-control {{ $errors->has('coordinates.' . $i) ? 'is-invalid' : '' }}"
                                                    type="text" wire:model.lazy="coordinates.{{ $i }}"
                                                    placeholder="{{ __('Insert Zone Coordinate') }} {{ $i + 1 }}">
                                                @error('coordinates.' . $i)
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-2 d-flex justify-content-center">
                                                <button class="btn btn-danger"
                                                    wire:click.prevent="removeCoordinate({{ $i }})">{{ __('Remove') }}</button>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="py-3 d-flex justify-content-center">
                                        <button class="btn btn-success"
                                            wire:click.prevent="addCoordinate">{{ __('Add') }}</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button class="btn btn-primary" type="button" wire:loading.attr="disabled"
                        wire:click.prevent="update">
                        <span wire:loading.remove>{{ __('Update') }}</span>
                        <div wire:loading>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#zoneTable').DataTable({
                columnDefs: [{
                    targets: '_all',
                    className: 'dt-center'
                }]
            });
        });

        const viewZoneModalEl = document.getElementById('viewZoneModal')
        viewZoneModalEl.addEventListener('hidden.bs.modal', event => {
            Livewire.emit('closeModal');
        })

        const updateZoneModalEl = document.getElementById('updateZoneModal')
        updateZoneModalEl.addEventListener('hidden.bs.modal', event => {
            Livewire.emit('closeModal');
        })
    </script>
@endpush
