@push('styles')
    {{-- <!-- SUMMERNOTE CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet"> --}}
@endpush

<div>
    <!-- Wizard card example with navigation-->
    <div class="card">
        <div class="card-header border-bottom">
            <!-- Wizard navigation-->
            <div class="nav nav-pills nav-justified flex-column flex-xl-row nav-wizard" id="cardTab" role="tablist">
                @foreach ($questionCategoryList as $index => $questionCategory)
                    @php
                        $category = DB::table('question_category')
                            ->where('code', $questionCategory)
                            ->first()->name;
                    @endphp

                    <!-- Wizard navigation item {{ $index }}-->
                    <a class="nav-item nav-link {{ $index == 0 ? 'active' : '' }}" id="answer{{ $index }}-tab"
                        href="#answer{{ $index }}" data-bs-toggle="tab" role="tab"
                        aria-controls="answer{{ $index }}" aria-selected="true" wire:ignore.self>
                        <div class="wizard-step-icon">{{ $index + 1 }}</div>
                        <div class="wizard-step-text">
                            <div class="wizard-step-text-name">
                                {{ __($category) }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="cardTabContent">
                @foreach ($questionCategoryList as $index => $questionCategory)
                    @php
                        $category = DB::table('question_category')
                            ->where('code', $questionCategory)
                            ->first()->name;
                    @endphp

                    <!-- Wizard tab pane item {{ $index }}-->
                    <div class="tab-pane py-5 py-xl-10 fade  {{ $index == 0 ? 'show active' : '' }}"
                        id="answer{{ $index }}" role="tabpanel" aria-labelledby="answer{{ $index }}-tab"
                        wire:ignore.self>
                        <div class="row justify-content-center">
                            <div class="col-xxl-11 col-xl-11">
                                <h3 class="text-primary">{{ __('Step') }} {{ $index + 1 }}</h3>
                                <h5 class="card-title mb-4">
                                    @switch($category)
                                        @case('Electric')
                                        @case('Water')
                                            {{ __('Answer the questions on how you able to save your ' . $category . ' Consumption') }}
                                        @break

                                        @case('Used Oil')
                                        @case('Recycle')
                                            {{ __('Answer the questions on how you able to increase your ' . $category . ' Collection') }}
                                        @break

                                        @default
                                            {{ '' }}
                                    @endswitch
                                </h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>{{ __('Question') }}</th>
                                                <th>{{ __('Answer') }}</th>
                                                <th>{{ __('Menu') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($submission->competition->getQuestionByCategory($questionCategory) as $indexQ => $questionObj)
                                                <tr>
                                                    <td>{{ $indexQ + 1 }}</td>
                                                    <td>{{ $questionObj->getValue('text') }}</td>
                                                    <td>{{ $questionObj->getAnswerBySubmissionID($submission_id) ? $questionObj->getAnswerBySubmissionID($submission_id)->text : __('No Answer Given') }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-toolbar justify-content-center" role="toolbar"
                                                            aria-label="Toolbar with button groups">
                                                            <div class="btn-group" role="group"
                                                                aria-label="Action Button">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewAnswerModal"
                                                                    wire:click.prevent='open({{ $questionObj->id }})'
                                                                    wire:ignore>
                                                                    <i data-bs-toggle="tooltip"
                                                                        data-bs-title="{{ __('View Answer for this Question') }}"
                                                                        data-feather="eye"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#updateAnswerModal"
                                                                    wire:click.prevent='open({{ $questionObj->id }})'
                                                                    wire:ignore>
                                                                    <i data-bs-toggle="tooltip"
                                                                        data-bs-title="{{ __('Edit Answer for this Question') }}"
                                                                        data-feather="edit-2"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- View Answer Modal -->
    <div class="modal fade" id="viewAnswerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewAnswerModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewAnswerModalLabel">{{ __('View Answer') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ __('Question') }}</th>
                                <td>{{ __($answer->question ? $answer->question->getValue('text') : '') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Your Answer') }}</th>
                                <td>{{ $answer->text ?? __('No Answer Given') }}</td>
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

    <!-- Update Answer Modal -->
    <div class="modal fade" id="updateAnswerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="updateAnswerModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateAnswerModalLabel">{{ __('Update Answer') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="w-25">{{ __('Question') }}</th>
                                <td>{{ $question ? $question->getValue('text') : '' }}?</td>
                            </tr>
                            <tr>
                                <th class="w-25">{{ __('Example Answer') }}</th>
                                <td>{{ $question ? $question->getValue('example') : '' }}</td>
                            </tr>
                        </table>
                    </div>
                    <form>
                        <div class="mb-3">
                            <label for="answer.text" class="form-label">{{ __('Your Answer') }}</label>
                            <textarea class="form-control {{ $errors->has('answer.text') ? 'is-invalid' : '' }}" id="answer.text" rows="2"
                                wire:model.lazy="answer.text" placeholder="{{ __('Insert your Answer for this Question') }}"></textarea>
                            @error('answer.text')
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
                    <button type="submit" class="btn btn-primary"
                        wire:click.prevent="update()">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    {{-- <!-- SUMMERNOTE JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script src="{{asset('js/summernote/lang/summernote-' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script> --}}
    <script>
        // $('#answer_text').summernote({
        //     lang: '{{ LaravelLocalization::getCurrentLocale() }}',
        //     placeholder: '{{ __('Insert your Answer for this Question') }}',
        //     tabsize: 2,
        //     height: 100,
        //     toolbar: [
        //         ['style', ['style']],
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['color', ['color']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //     ]
        // });

        Livewire.on('changeTabAnswer', tab_state => {
            const answerTab = document.getElementById('answer' + tab_state + '-tab');
            bootstrap.Tab.getOrCreateInstance(answerTab).show();
        })
    </script>
@endpush
