@push('styles')
@endpush

<div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered text-center" id="evidenceTable" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th class="w-50">{{ __('Evidence') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evidences as $evidenceObj)
                    <tr>
                        <td>{{ $evidenceObj->title }}</td>
                        <td>{{ __($evidenceObj->getCategory()->description) }}</td>
                        <td>
                            <div class="btn-toolbar justify-content-center" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <form action="{{ route('admin.contest.submission.download') }}" method="post"
                                        target="_blank">
                                        @csrf

                                        <button type="submit" class="btn btn-primary btn-sm"
                                            value="{{ $evidenceObj->id }}" name="evidence_id">
                                            <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Evidence') }}"
                                                data-feather="eye"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {

            var evidenceTable = $('#evidenceTable').DataTable({
                columnDefs: [{
                    targets: '_all',
                    className: 'dt-center'
                }]
            });

            $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function(event) {
                var tabID = $(event.target).attr('data-bs-target');
                if (tabID === '#pills-evidence') {
                    evidenceTable.columns.adjust().responsive.recalc();
                }
            });

        });
    </script>
@endpush
