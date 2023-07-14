<div>
    <div class="pt-3 pb-3 d-flex justify-content-end align-items-middle">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQuestionModal"
            wire:click.prevent='open()'>
            {{ __('Create Question') }}
        </button>
    </div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered" id="questionTable">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Question') }}</th>
                    <th>{{ __('Example Answer') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->text }}?</td>
                        <td>{{ $question->example }}</td>
                        <td>{{ __($question->getCategory()->name) }}</td>
                        <td>
                            <div class="btn-toolbar justify-content-center" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewQuestionModal"
                                        wire:click.prevent='open({{ $question->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Question') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#updateQuestionModal"
                                        wire:click.prevent='open({{ $question->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('Update Question') }}"
                                            data-feather="edit-2"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click.prevent='askDelete({{ $question->id }})'><i data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('Delete Question') }}"
                                            data-feather="trash-2"></i></button>
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
                            <label for="text" class="form-label">{{ __('Question') }}
                                <small class="text-muted">{{ __("(No need to put '?' symbol)") }}</small></label>
                            <input type="text"
                                class="form-control {{ $errors->has('question.text') ? 'is-invalid' : '' }}"
                                id="text" wire:model.lazy="question.text"
                                placeholder="{{ __('Enter The Question') }}" required>
                            @error('question.text')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="example" class="form-label">{{ __('Example Answer') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('question.example') ? 'is-invalid' : '' }}"
                                id="example" wire:model.lazy="question.example"
                                placeholder="{{ __('Enter Question Example Answer') }}" required>
                            @error('question.example')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('Category') }}</label>
                            <div id="category">
                                @foreach (DB::table('question_category')->get() as $index => $category)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            wire:model.lazy='question.category' id="category{{ $index }}"
                                            value="{{ $category->code }}">
                                        <label class="form-check-label"
                                            for="category{{ $index }}">{{ __($category->name) }}</label>
                                    </div>
                                @endforeach
                            </div>
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
                                <th>{{ __('Text') }}</th>
                                <td>{{ $question->text }}?</td>
                            </tr>
                            <tr>
                                <th>{{ __('Example Answer') }}</th>
                                <td>{{ $question->example }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Category') }}</th>
                                <td>{{ __($question->getCategory()->name ?? '') }}</td>
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
                            <label for="text" class="form-label">{{ __('Question') }}
                                <small class="text-muted">{{ __("(No need to put '?' symbol)") }}</small></label>
                            <input type="text"
                                class="form-control {{ $errors->has('question.text') ? 'is-invalid' : '' }}"
                                id="text" wire:model.lazy="question.text"
                                placeholder="{{ __('Enter The Question') }}" required>
                            @error('question.text')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="example" class="form-label">{{ __('Example Answer') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('question.example') ? 'is-invalid' : '' }}"
                                id="example" wire:model.lazy="question.example"
                                placeholder="{{ __('Enter Question Example Answer') }}" required>
                            @error('question.example')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('Category') }}</label>
                            <div id="category">
                                @foreach (DB::table('question_category')->get() as $index => $category)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            wire:model.lazy='question.category' id="category{{ $index }}"
                                            value="{{ $category->code }}">
                                        <label class="form-check-label"
                                            for="category{{ $index }}">{{ __($category->name) }}</label>
                                    </div>
                                @endforeach
                            </div>
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
            $('#questionTable').DataTable({
                columnDefs: [{
                    targets: '_all',
                    className: 'dt-center'
                }]
            });
        });
    </script>
@endpush
