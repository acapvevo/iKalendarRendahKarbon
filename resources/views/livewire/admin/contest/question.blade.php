@php
    $locale = null;
    if (LaravelLocalization::getCurrentLocale() == 'ms') {
        $locale = 'en';
    }
@endphp
<div>
    <div class="pt-3 pb-3 d-flex justify-content-end align-items-middle">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQuestionModal"
            wire:click.prevent='open()'>
            {{ __('Create Question') }}
        </button>
    </div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered" id="questionTable" style="width: 100%">
            <thead class="table-primary">
                <tr>
                    <th style="width: 40%">{{ __('Question') }}</th>
                    <th>{{ __('Example Answer') }}</th>
                    <th style="width: 10%">{{ __('Category') }}</th>
                    <th style="width: 10%">{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $questionObj)
                    <tr>
                        <td>{{ $questionObj->getValue('text') }}? <br>
                            ({{ $questionObj->getCurrentTranslation('text', $locale) }}?)
                        </td>
                        <td>{{ $questionObj->getValue('example') }} <br>
                            ({{ $questionObj->getCurrentTranslation('example', $locale) }})
                        </td>
                        <td>{{ __($questionObj->getCategory()->description) }}</td>
                        <td>
                            <div class="btn-toolbar justify-content-center" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewQuestionModal"
                                        wire:click.prevent='open({{ $questionObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Question') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#updateQuestionModal"
                                        wire:click.prevent='open({{ $questionObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('Update Question') }}"
                                            data-feather="edit-2"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click.prevent='askDelete({{ $questionObj->id }})'><i
                                            data-bs-toggle="tooltip" data-bs-title="{{ __('Delete Question') }}"
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

    <!-- Create Question Modal -->
    <div class="modal fade" id="createQuestionModal" tabindex="-1" aria-labelledby="createQuestionModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createQuestionModalLabel">{{ __('Create Question') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <form id="createQuestionForm">

                        <div class="mb-3">
                            <label for="text_malay" class="form-label">{{ __('Question') }} ({{ __('Malay') }})
                                <small class="text-muted">{{ __("(No need to put '?' symbol)") }}</small></label>
                            <input type="text"
                                class="form-control {{ $errors->has('text_malay') ? 'is-invalid' : '' }}"
                                id="text_malay" wire:model.lazy="text_malay"
                                placeholder="{{ __('Enter The Question in Malay') }}" required>
                            @error('text_malay')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="text_english" class="form-label">{{ __('Question') }} ({{ __('English') }})
                                <small class="text-muted">{{ __("(No need to put '?' symbol)") }}</small></label>
                            <input type="text"
                                class="form-control {{ $errors->has('text_english') ? 'is-invalid' : '' }}"
                                id="text_english" wire:model.lazy="text_english"
                                placeholder="{{ __('Enter The Question in English') }}" required>
                            @error('text_english')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="example_malay" class="form-label">{{ __('Example Answer') }}
                                ({{ __('Malay') }})</label>
                            <input type="text"
                                class="form-control {{ $errors->has('example_malay') ? 'is-invalid' : '' }}"
                                id="example_malay" wire:model.lazy="example_malay"
                                placeholder="{{ __('Enter The Example Answer for this Question in Malay') }}" required>
                            @error('example_malay')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="example_english" class="form-label">{{ __('Example Answer') }}
                                ({{ __('English') }})</label>
                            <input type="text"
                                class="form-control {{ $errors->has('example_english') ? 'is-invalid' : '' }}"
                                id="example_english" wire:model.lazy="example_english"
                                placeholder="{{ __('Enter The Example Answer for this Question in English') }}"
                                required>
                            @error('example_english')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('Category') }}</label>
                            <div id="category">
                                @foreach ($submission_categories as $index => $category)
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input {{ $errors->has('question.category') ? 'is-invalid' : '' }}"
                                            type="radio" wire:model.lazy='question.category'
                                            id="category{{ $index }}" value="{{ $category->code }}">
                                        <label class="form-check-label"
                                            for="category{{ $index }}">{{ __($category->description) }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('question.category')
                                <div class="invalid-feedback" style="display: block">
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

    <!-- View Question Modal -->
    <div class="modal fade" id="viewQuestionModal" tabindex="-1" aria-labelledby="viewQuestionModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewQuestionModalLabel">{{ __('View Question') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ __('Question') }}</th>
                                <td style="width: 40%">{{ $question->getValue('text') }}?</td>
                                <td style="width: 40%">{{ $question->getCurrentTranslation('text', $locale) }}?</td>
                            </tr>
                            <tr>
                                <th>{{ __('Example Answer') }}</th>
                                <td>{{ $question->getValue('example') }}</td>
                                <td>{{ $question->getCurrentTranslation('example', $locale) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Category') }}</th>
                                <td colspan="2" class="text-center">
                                    {{ __($question->getCategory()->description ?? '') }}
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

    <!-- Update Question Modal -->
    <div class="modal fade" id="updateQuestionModal" tabindex="-1" aria-labelledby="updateQuestionModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateQuestionModalLabel">{{ __('Update Question') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <form id="updateQuestionForm">

                        <div class="mb-3">
                            <label for="text_malay" class="form-label">{{ __('Question') }} ({{ __('Malay') }})
                                <small class="text-muted">{{ __("(No need to put '?' symbol)") }}</small></label>
                            <input type="text"
                                class="form-control {{ $errors->has('text_malay') ? 'is-invalid' : '' }}"
                                id="text_malay" wire:model.lazy="text_malay"
                                placeholder="{{ __('Enter The Question in Malay') }}" required>
                            @error('text_malay')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="text_english" class="form-label">{{ __('Question') }} ({{ __('English') }})
                                <small class="text-muted">{{ __("(No need to put '?' symbol)") }}</small></label>
                            <input type="text"
                                class="form-control {{ $errors->has('text_english') ? 'is-invalid' : '' }}"
                                id="text_english" wire:model.lazy="text_english"
                                placeholder="{{ __('Enter The Question in English') }}" required>
                            @error('text_english')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="example_malay" class="form-label">{{ __('Example Answer') }}
                                ({{ __('Malay') }})
                                <small class="text-muted">{{ __("(No need to put '?' symbol)") }}</small></label>
                            <input type="text"
                                class="form-control {{ $errors->has('example_malay') ? 'is-invalid' : '' }}"
                                id="example_malay" wire:model.lazy="example_malay"
                                placeholder="{{ __('Enter The Example Answer for this Question in Malay') }}"
                                required>
                            @error('example_malay')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="example_english" class="form-label">{{ __('Example Answer') }}
                                ({{ __('English') }})
                                <small class="text-muted">{{ __("(No need to put '?' symbol)") }}</small></label>
                            <input type="text"
                                class="form-control {{ $errors->has('example_english') ? 'is-invalid' : '' }}"
                                id="example_english" wire:model.lazy="example_english"
                                placeholder="{{ __('Enter The Example Answer for this Question in English') }}"
                                required>
                            @error('example_english')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('Category') }}</label>
                            <div id="category">
                                @foreach ($submission_categories as $index => $category)
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input {{ $errors->has('question.category') ? 'is-invalid' : '' }}"
                                            type="radio" wire:model.lazy='question.category'
                                            id="category{{ $index }}" value="{{ $category->code }}">
                                        <label class="form-check-label"
                                            for="category{{ $index }}">{{ __($category->description) }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('question.category')
                                <div class="invalid-feedback" style="display: block">
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#questionTable').DataTable({
                columnDefs: [{
                    targets: '_all',
                    className: 'dt-center'
                }]
            });
        });
    </script>
@endpush
