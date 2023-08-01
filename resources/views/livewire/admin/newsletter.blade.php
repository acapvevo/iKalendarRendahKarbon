@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

<div>
    <div class="py-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNewsletterModal" wire:click.prevent="open">
            {{ __('Create Newsletter') }}
        </button>
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
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editNewsletterModal"
                                        wire:click.prevent='open({{ $newsletterObj->id }})'>
                                        <i data-bs-toggle="tooltip" data-bs-title="{{ __('Edit Newsletter') }}"
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

    <!-- Create Newsletter Modal -->
    <div class="modal fade" id="createNewsletterModal" tabindex="-1" aria-labelledby="createNewsletterModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createNewsletterModalLabel">{{ __('Create Newsletter') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>

                        <div class="mb-3">
                            <label for="thumbnail_label" class="form-label">{{ __('Thumbnail') }}</label>
                            <div class="input-group custom-file-button" id="thumbnail_label">
                                <label class="input-group-text" for="thumbnail"
                                    role="button">{{ __('Browse') }}</label>
                                <label for="thumbnail"
                                    class="form-control {{ $errors->has('thumbnail') ? 'is-invalid' : '' }}"
                                    id="eviden-label" role="button">{{ $thumbnail_label }}</label>
                                <input type="file" required class="d-none form-control" id="thumbnail"
                                    wire:model.lazy="thumbnail">
                                @error('thumbnail')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Title') }}</label>
                            <input type="email"
                                class="form-control {{ $errors->has('newsletter.title') ? 'is-invalid' : '' }}"
                                id="title" placeholder="{{ __('Insert Newsletter Title') }}"
                                wire:model.lazy="newsletter.title">
                            @error('newsletter.title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">{{ __('Location') }}</label>
                            <input type="email"
                                class="form-control {{ $errors->has('newsletter.location') ? 'is-invalid' : '' }}"
                                id="location" placeholder="{{ __('Insert Newsletter Location') }}"
                                wire:model.lazy="newsletter.location">
                            @error('newsletter.location')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('Category') }}</label>
                            <div id="category">
                                @foreach (DB::table('newsletter_category')->get() as $index => $category)
                                    <div class="form-check form-check-inline"
                                        wire:key="div_newsletter_category_{{ $index }}">
                                        <input class="form-check-input" type="radio" id="category"
                                            value="{{ $category->code }}" wire:model.lazy='newsletter.category'
                                            wire:key="input_newsletter_category_{{ $index }}">
                                        <label class="form-check-label" for="category"
                                            wire:key="label_newsletter_category_{{ $index }}">{{ __($category->description) }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('newsletter.category')
                                <div class="invalid-feedback" class="display-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content_create" class="form-label">{{ __('Content') }}</label>
                            <div wire:ignore>
                                <textarea class="form-control" id="content_create"></textarea>
                            </div>
                            @error('newsletter.category')
                                <div class="invalid-feedback" class="display-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button class="btn btn-primary" type="button" wire:loading.attr="disabled"
                        wire:click.prevent="create">
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
                                <th>{{ __('Thumbnail') }}</th>
                                <td>
                                    @if ($newsletter->thumbnail)
                                        <img src="{{ route('admin.newsletter.thumbnail', ['newsletter_id' => $newsletter->id]) }}"
                                            class="img-fluid img-thumbnail mx-auto d-block"
                                            alt="Thumbnail Preview for {{ $newsletter->title }}">
                                    @else
                                        {{ __('No Thumbnail Uploaded') }}
                                    @endif
                                </td>
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

    <!-- Edit Newsletter Modal -->
    <div class="modal fade" id="editNewsletterModal" tabindex="-1" aria-labelledby="editNewsletterModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editNewsletterModalLabel">{{ __('Edit Newsletter') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>

                        <div class="mb-3">
                            <label for="thumbnail_label" class="form-label">{{ __('Thumbnail') }}</label>
                            <div class="input-group custom-file-button" id="thumbnail_label">
                                <label class="input-group-text" for="thumbnail"
                                    role="button">{{ __('Browse') }}</label>
                                <label for="thumbnail"
                                    class="form-control {{ $errors->has('thumbnail') ? 'is-invalid' : '' }}"
                                    id="eviden-label" role="button">{{ $thumbnail_label }}</label>
                                <input type="file" required class="d-none form-control" id="thumbnail"
                                    wire:model.lazy="thumbnail">
                                @error('thumbnail')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Title') }}</label>
                            <input type="email"
                                class="form-control {{ $errors->has('newsletter.title') ? 'is-invalid' : '' }}"
                                id="title" placeholder="{{ __('Insert Newsletter Title') }}"
                                wire:model.lazy="newsletter.title">
                            @error('newsletter.title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">{{ __('Location') }}</label>
                            <input type="email"
                                class="form-control {{ $errors->has('newsletter.location') ? 'is-invalid' : '' }}"
                                id="location" placeholder="{{ __('Insert Newsletter Location') }}"
                                wire:model.lazy="newsletter.location">
                            @error('newsletter.location')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('Category') }}</label>
                            <div id="category">
                                @foreach (DB::table('newsletter_category')->get() as $index => $category)
                                    <div class="form-check form-check-inline"
                                        wire:key="div_newsletter_category_{{ $index }}">
                                        <input class="form-check-input" type="radio" id="category"
                                            value="{{ $category->code }}" wire:model.lazy='newsletter.category'
                                            wire:key="input_newsletter_category_{{ $index }}">
                                        <label class="form-check-label" for="category"
                                            wire:key="label_newsletter_category_{{ $index }}">{{ __($category->description) }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('newsletter.category')
                                <div class="invalid-feedback" class="display-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content_update" class="form-label">{{ __('Content') }}</label>
                            <div wire:ignore>
                                <textarea class="form-control" id="content_update">{!! $newsletter->content !!}</textarea>
                            </div>
                            @error('newsletter.category')
                                <div class="invalid-feedback" class="display-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button class="btn btn-primary" type="button" wire:loading.attr="disabled"
                        wire:click.prevent="update">
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('js/summernote/lang/summernote-' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    <script>
        const options = {
            lang: '{{ LaravelLocalization::getCurrentLocale() }}',
            placeholder: '{{ __('Insert Newsletter Content') }}',
            height: 500,
            callbacks: {
                onChange: function(contents, $editable) {
                    @this.set('newsletter.content', contents);
                }
            }
        }

        $(document).ready(function() {
            $('#newsletterTable').DataTable();
        });

        const editNewsletterModalEl = document.getElementById('editNewsletterModal')
        editNewsletterModalEl.addEventListener('show.bs.modal', event => {
            $('#content_update').summernote(options);
        })
        editNewsletterModalEl.addEventListener('hidden.bs.modal', event => {
            Livewire.emit('closeModal')
        })
        Livewire.on('setNewsletterContent', content => {
            $('#content_update').summernote('code', content);
        })

        const createNewsletterModalEl = document.getElementById('createNewsletterModal')
        createNewsletterModalEl.addEventListener('show.bs.modal', event => {
            $('#content_create').summernote(options);
        })

        const viewNewsletterModalEl = document.getElementById('viewNewsletterModal')
        viewNewsletterModalEl.addEventListener('hidden.bs.modal', event => {
            Livewire.emit('closeModal')
        })
    </script>
@endpush
