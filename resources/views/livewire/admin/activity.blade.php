@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
<div>
    <div class="py-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createActivityModal">
            {{ __('Add Activity') }}
        </button>
    </div>
    <div wire:ignore class="table-responsive">
        <table class="table table-bordered" style="width: 100%" id="activityTable">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Activity') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Total Carbon Emission') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activityObj)
                    <tr>
                        <td>{{ $activityObj->title }}</td>
                        <td>{{ $activityObj->getDate() }}</td>
                        <td>{{ number_format($activityObj->total_carbon_emission, 2) }} kgCO<sub>2</sub></td>
                        <td>
                            <div class="btn-toolbar justify-content-center" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewActivityModal"
                                        wire:click.prevent='open({{ $activityObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Activity') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#updateActivityModal"
                                        wire:click.prevent='open({{ $activityObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('Update Activity') }}"
                                            data-feather="edit-2"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click.prevent='askDelete({{ $activityObj->id }})'><i
                                            data-bs-toggle="tooltip" data-bs-title="{{ __('Delete Activity') }}"
                                            data-feather="trash-2"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Activity Modal -->
    <div wire:ignore.self class="modal fade" id="createActivityModal" tabindex="-1"
        aria-labelledby="createActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createActivityModalLabel">{{ __('Add Activity') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="mb-3 row">
                            <div class="col-lg-8">
                                <label for="title" class="form-label">{{ __('Title') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('activity.title') ? 'is-invalid' : '' }}"
                                    id="title" wire:model.lazy="activity.title"
                                    placeholder="{{ __('Insert Activity Title') }}" required>
                                @error('activity.title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label for="date" class="form-label">{{ __('Date') }}</label>
                                <div>
                                    <input type="text"
                                        class="date form-control {{ $errors->has('activity.date') ? 'is-invalid' : '' }}"
                                        id="date" wire:model.lazy="activity.date"
                                        placeholder="{{ __('Insert Activity Date') }}" required>
                                </div>
                                @error('activity.date')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        @foreach ($activity_categories as $category)
                            <hr>
                            <h4 class="text-center">{{ strtoupper(__($category->description)) }}</h4>
                            <hr>

                            <div class="mb-3 row">
                                <div class="col-lg-6">
                                    <label for="{{ $category->name }}_weight"
                                        class="form-label">{{ __('Total Weight') }}</label>
                                    <div class="input-group has-validation">
                                        <input type="number"
                                            class="form-control {{ $errors->has($category->name . '.weight') ? 'is-invalid' : '' }}"
                                            id="{{ $category->name }}_weight"
                                            wire:model.lazy="{{ $category->name }}.weight"
                                            aria-describedby="{{ $category->name }}_weight_desc"
                                            placeholder="{{ __('Insert ' . $category->description . ' Total Weight') }}"
                                            aria-label="{{ __('Insert ' . $category->description . ' Total Weight') }}"
                                            required>
                                        <span class="input-group-text"
                                            id="{{ $category->name }}_weight_desc">{{ $category->symbol }}</span>
                                        @error($category->name . '.weight')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="{{ $category->name }}_value"
                                        class="form-label">{{ __('Total Sell Value') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="{{ $category->name }}_value_desc">RM</span>
                                        <input type="number"
                                            class="form-control {{ $errors->has($category->name . '.value') ? 'is-invalid' : '' }}"
                                            id="{{ $category->name }}_value"
                                            wire:model.lazy="{{ $category->name }}.value"
                                            aria-describedby="{{ $category->name }}_value_desc"
                                            placeholder="{{ __('Insert ' . $category->description . ' Total Sell Value') }}"
                                            aria-label="{{ __('Insert ' . $category->description . ' Total Sell Value') }}"
                                            required>
                                        @error($category->name . '.value')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
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

    <!-- View Activity Modal -->
    <div wire:ignore.self class="modal fade" id="viewActivityModal" tabindex="-1"
        aria-labelledby="viewActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewActivityModalLabel">{{ __('View Activity') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Retrieving Activity Data') }}...</strong>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="w-25">{{ __('Title') }}</th>
                                    <td colspan="3">{{ $activity->title }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <td colspan="3">{{ $activity->date ? $activity->getDate() : '' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-center h3" colspan="4">{{ __('Collection Details') }}</th>
                                </tr>
                                <tr class="text-center">
                                    <th style="width: 15%">{{ __('Category') }}</th>
                                    <th>{{ __('Total Weight') }}</th>
                                    <th>{{ __('Total Sell Value') }}</th>
                                    <th>{{ __('Carbon Emission') }}</th>
                                </tr>
                                @foreach ($activity_categories as $category)
                                    <tr class="text-center">
                                        <td>{{ __($category->description) }}</td>
                                        <td>{{ number_format(${$category->name}->weight ?? 0, 2) }}
                                            {{ $category->symbol }}</td>
                                        <td>RM {{ number_format(${$category->name}->value ?? 0, 2) }}</td>
                                        <td>{{ number_format(${$category->name}->carbon_emission ?? 0, 2) }} kgCO<sub>2</sub></td>
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

    <!-- Update Activity Modal -->
    <div wire:ignore.self class="modal fade" id="updateActivityModal" tabindex="-1"
        aria-labelledby="updateActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateActivityModalLabel">{{ __('Update Activity') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if ($isLoading)
                        <div class="d-flex align-items-center justify-content-center loading">
                            <span class="spinner-border text-primary" role="status">
                            </span> &nbsp;
                            <strong class="text-primary">{{ __('Retrieving Activity Data') }}...</strong>
                        </div>
                    @else
                        <form>
                            <div class="mb-3 row">
                                <div class="col-lg-8">
                                    <label for="title" class="form-label">{{ __('Title') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('activity.title') ? 'is-invalid' : '' }}"
                                        id="title" wire:model.lazy="activity.title"
                                        placeholder="{{ __('Insert Activity Title') }}" required>
                                    @error('activity.title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label for="date" class="form-label">{{ __('Date') }}</label>
                                    <div>
                                        <input type="text"
                                            class="date form-control {{ $errors->has('activity.date') ? 'is-invalid' : '' }}"
                                            id="date" wire:model.lazy="activity.date"
                                            placeholder="{{ __('Insert Activity Date') }}" required>
                                    </div>
                                    @error('activity.date')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            @foreach ($activity_categories as $category)
                                <hr>
                                <h4 class="text-center">{{ strtoupper(__($category->description)) }}</h4>
                                <hr>

                                <div class="mb-3 row">
                                    <div class="col-lg-6">
                                        <label for="{{ $category->name }}_weight"
                                            class="form-label">{{ __('Total Weight') }}</label>
                                        <div class="input-group has-validation">
                                            <input type="number"
                                                class="form-control {{ $errors->has($category->name . '.weight') ? 'is-invalid' : '' }}"
                                                id="{{ $category->name }}_weight"
                                                wire:model.lazy="{{ $category->name }}.weight"
                                                aria-describedby="{{ $category->name }}_weight_desc"
                                                placeholder="{{ __('Insert ' . $category->description . ' Total Weight') }}"
                                                aria-label="{{ __('Insert ' . $category->description . ' Total Weight') }}"
                                                required>
                                            <span class="input-group-text"
                                                id="{{ $category->name }}_weight_desc">{{ $category->symbol }}</span>
                                            @error($category->name . '.weight')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="{{ $category->name }}_value"
                                            class="form-label">{{ __('Total Sell Value') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text"
                                                id="{{ $category->name }}_value_desc">RM</span>
                                            <input type="number"
                                                class="form-control {{ $errors->has($category->name . '.value') ? 'is-invalid' : '' }}"
                                                id="{{ $category->name }}_value"
                                                wire:model.lazy="{{ $category->name }}.value"
                                                aria-describedby="{{ $category->name }}_value_desc"
                                                placeholder="{{ __('Insert ' . $category->description . ' Total Sell Value') }}"
                                                aria-label="{{ __('Insert ' . $category->description . ' Total Sell Value') }}"
                                                required>
                                            @error($category->name . '.value')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/flatpickr/lang/' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#activityTable').DataTable({
                columnDefs: [{
                    targets: '_all',
                    className: 'dt-center'
                }]
            });

            initFlatpickr();
        });

        function initFlatpickr() {
            $(".date").flatpickr({
                locale: "{{ LaravelLocalization::getCurrentLocale() }}",
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    localStorage.setItem('date', dateStr);
                    @this.set('activity.date', dateStr);
                },
            });
        }

        window.livewire.on('flatpickr', () => {
            initFlatpickr();
        });

        const viewActivityModalEl = document.getElementById('viewActivityModal')
        viewActivityModalEl.addEventListener('hidden.bs.modal', event => {
            Livewire.emit('closeModal');
        })

        const updateActivityModalEl = document.getElementById('updateActivityModal')
        updateActivityModalEl.addEventListener('hidden.bs.modal', event => {
            Livewire.emit('closeModal');
        })
    </script>
@endpush
