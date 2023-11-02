@push('styles')
@endpush

<div>
    <div class="py-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEvidenceModal">
            {{ __('Add Evidence') }}
        </button>
    </div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered text-center" id="evidenceTable" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th class="w-75">{{ __('Evidence') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evidences as $evidenceObj)
                    <tr>
                        <td>{{ $evidenceObj->title }}</td>
                        <td>
                            <div class="justify-content-center">
                                <div class="btn-group-vertical d-lg-none" role="group"
                                    aria-label="Vertical button group">
                                    <form action="{{ route('community.contest.submission.download') }}" method="post"
                                        target="_blank">
                                        @csrf

                                        <button type="submit" class="btn btn-primary btn-sm"
                                            value="{{ $evidenceObj->id }}" name="evidence_id">
                                            <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Evidence') }}"
                                                data-feather="eye"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click.prevent='askDelete({{ $evidenceObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('Delete Evidence') }}"
                                            data-feather="trash-2"></i>
                                    </button>
                                </div>
                                <div class="btn-group d-none d-lg-inline-flex" role="group"
                                    aria-label="Horizontal button group">
                                    <form action="{{ route('community.contest.submission.download') }}" method="post"
                                        target="_blank">
                                        @csrf

                                        <button type="submit" class="btn btn-primary btn-sm"
                                            value="{{ $evidenceObj->id }}" name="evidence_id">
                                            <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Evidence') }}"
                                                data-feather="eye"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click.prevent='askDelete({{ $evidenceObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('Delete Evidence') }}"
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

    <!-- Create Evidence Modal -->
    <div wire:ignore.self class="modal fade" id="addEvidenceModal" tabindex="-1"
        aria-labelledby="addEvidenceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addEvidenceModalLabel">{{ __('Add Evidence') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Title') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('evidence.title') ? 'is-invalid' : '' }}"
                                id="title" placeholder="{{ __('Insert your Evidence Title') }}"
                                wire:model.lazy='evidence.title'>
                            @error('evidence.title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file_label" class="form-label">{{ __('File') }}</label>
                            <div class="input-group custom-file-button" id="file_label">
                                <label class="input-group-text" for="file"
                                    role="button">{{ __('Browse') }}</label>
                                <label for="file"
                                    class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                    id="eviden-label" role="button">{{ $file_label }}</label>
                                <input type="file" required class="d-none form-control" id="file"
                                    wire:model.lazy="file" aria-describedby="fileHelpText">
                                @error('file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div id="fileHelpText" class="form-text">
                                {{ __('Accepted Format: .jpg, .pdf, .png, .doc, .docx | Max File Size: 4MB') }}
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"
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

</div>

@push('scripts')
    <script type="text/javascript">
        // $(document).ready(function() {
        //     $('#evidenceTable').DataTable({
        //         columnDefs: [{
        //             targets: '_all',
        //             className: 'dt-center'
        //         }]
        //     });
        // });
    </script>
@endpush
