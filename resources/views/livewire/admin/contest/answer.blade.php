@push('styles')
@endpush

<div>
    <!-- Wizard card example with navigation-->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" wire:ignore>
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>{{ __('Question') }}</th>
                            <th>{{ __('Answer') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($submission->competition->questions as $question)
                            <tr>
                                <td>{{ $question->getValue('text') }}</td>
                                <td>{{ $question->getAnswerBySubmissionID($submission_id) ? $question->getAnswerBySubmissionID($submission_id)->text : __('No Answer Given') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
