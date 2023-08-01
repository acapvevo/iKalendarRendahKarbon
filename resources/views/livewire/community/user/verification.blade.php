@push('styles')
@endpush
<div>
    <form id="verifyAccountForm" wire:submit.prevent="save">
        <div class="mb-3">
            <label for="identification_card_label" class="form-label">{{ __('Identification Card') }}</label>
            <div class="input-group custom-file-button" id="identification_card_label">
                <label class="input-group-text" for="identification_card" role="button">{{ __('Browse') }}</label>
                <label for="identification_card"
                    class="form-control {{ $errors->has('identification_card') ? 'is-invalid' : '' }}" id="eviden-label"
                    role="button">{{ $identification_card_label }}</label>
                <input type="file" required class="d-none form-control" id="identification_card"
                    wire:model="identification_card">
                @error('identification_card')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </form>
</div>
@push('scripts')
@endpush
