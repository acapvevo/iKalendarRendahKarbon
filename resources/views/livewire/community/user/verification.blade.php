@push('styles')
@endpush
<div>
    <div class="accordion" id="accordionExample" wire:ignore>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    {{ __('How to upload your Identification Card?') }}
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <ul>
                        <li>{{ __('You need to upload the front and back of your Identification Card') }}</li>
                        <li>{{ __('Make sure your uploaded Identification Card is the same as the owner of this account') }}
                        </li>
                        <li>{{ __('Make sure your Identification Card is legible and clear') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2"></div>

    <form id="verifyAccountForm" wire:submit.prevent="save">
        <div class="mb-3">
            <label for="identification_card_label" class="form-label">{{ __('Identification Card') }}</label>
            <div class="input-group custom-file-button" id="identification_card_label">
                <label class="input-group-text" for="identification_card" role="button">{{ __('Browse') }}</label>
                <label for="identification_card"
                    class="form-control {{ $errors->has('identification_card') ? 'is-invalid' : '' }}" id="eviden-label"
                    role="button">{{ $identification_card_label }}</label>
                <input type="file" required class="d-none form-control" id="identification_card"
                    wire:model="identification_card" aria-describedby="identification_cardHelpBlock">
                <br>
                @error('identification_card')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div id="identification_cardHelpBlock" class="form-text d-block">
                {{ __('Accepted Format: .jpg, .pdf, .png | Max File Size: 4MB') }}
            </div>
        </div>
    </form>
</div>
@push('scripts')
@endpush
