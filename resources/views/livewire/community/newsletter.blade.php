<div>
    <div class="py-3 d-flex justify-content-end">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="subscribe">
            <label class="form-check-label" for="subscribe"
                {{ $community->isSubscribed ? 'checked' : '' }}>{{ __('Subscribe to our Newsletter') }}</label>
        </div>
    </div>
    <div class="table-responsive" wire:ignore>
        <table class="table table-bordered" id="newsletterTable" style="width:100%">
            <thead class="table-primary">
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Post Date') }}</th>
                    <th>{{ __('Menu') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($newsletters as $newsletterObj)
                    <tr>
                        <td>{{ $newsletterObj->title }}</td>
                        <td>{{ __($newsletterObj->getCategory()->description) }}</td>
                        <td>{{ $newsletterObj->getCreatedAt() }}</td>
                        <td>
                            <div class="btn-toolbar justify-content-center" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewNewsletterModal"
                                        wire:click.prevent='open({{ $newsletterObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('View Newsletter') }}"
                                            data-feather="eye"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- View Newsletter Modal -->
    <div class="modal fade" id="viewNewsletterModal" tabindex="-1" aria-labelledby="viewNewsletterModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewNewsletterModalLabel">{{ __('View Newsletter') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ __('Post Date') }}</th>
                                <td>{{ $newsletter ? $newsletter->getCreatedAt() : '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <td>{{ $newsletter->title ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Category') }}</th>
                                <td>{{ $newsletter ? __($newsletter->getCategory()->description ?? '') : '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="h3 text-center">{{ __('Content') }}</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    {!! $newsletter->content ?? '' !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

</div>
@push('scripts')
    <script>
        const viewNewsletterModalEl = document.getElementById('viewNewsletterModal')
        viewNewsletterModalEl.addEventListener('hidden.bs.modal', event => {
            Livewire.emit('closeModal')
        });

        const toggleSubscribeNewsletter = document.getElementById('subscribe');
        toggleSubscribeNewsletter.addEventListener('change', event => {
            Livewire.emit('toggleSubscribe');
        });
    </script>
@endpush
