@push('styles')
    {{-- <!-- SUMMERNOTE CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet"> --}}
@endpush

<div>
    <h5 class="mb-4">
        @switch($category_name)
            @case('electric')
            @case('water')
                {{ __('Answer the questions on how you able to save your ' . $category_description . ' Consumption') }}
            @break

            @case('recycle')
            @case('used_oil')
                {{ __('Answer the questions on how you able to increase your ' . $category_description . ' Collection') }}
            @break

            @default
                {{ '' }}
        @endswitch
    </h5>

    <div class="table-responsive" wire:ignore>
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
                @forelse ($questions as $indexQ => $questionObj)
                    <tr>
                        <td>{{ $indexQ + 1 }}</td>
                        <td>{{ $questionObj->getValue('text') }}</td>
                        <td>{{ $questionObj->getAnswerBySubmissionID($submission_id) ? $questionObj->getAnswerBySubmissionID($submission_id)->text : __('No Answer Given') }}
                        </td>
                        <td>
                            <div class="btn-toolbar justify-content-center" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewAnswerModal"
                                        wire:click.prevent='open({{ $questionObj->id }})'>
                                        <i data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('View Answer for this Question') }}"
                                            data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#updateAnswerModal"
                                        wire:click.prevent='open({{ $questionObj->id }})'>
                                        <i data-bs-toggle="tooltip"
                                            data-bs-title="{{ __('Edit Answer for this Question') }}"
                                            data-feather="edit-2"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th colspan="4" class="text-center">{{__("No Bonus Question for this Category")}}</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"
                        wire:click.prevent="update()">
                        <span wire:loading.remove>{{ __('Save') }}</span>
                        <div wire:loading wire:target="update">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Saving...') }}
                        </div>
                    </button>
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
