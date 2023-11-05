<div>
    <form wire:submit.prevent="update" id="updateUserForm">

        <!-- Profile -->
        <div class="pt-3 pb-3">
            <div class="h4 pb-2 mb-4 text-primary border-bottom border-primary">
                {{ __('Profile') }}
            </div>

            <div class="mb-3 row">
                <div class="col-12">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control {{ $errors->has('user.name') ? 'is-invalid' : '' }}"
                        id="name" wire:model.lazy="user.name" placeholder="{{ __('Enter Your Name') }}"
                        oninput="this.value = this.value.toUpperCase()">
                    @error('user.name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-lg-6 col-12">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input type="email" class="form-control {{ $errors->has('user.email') ? 'is-invalid' : '' }}"
                        id="email" wire:model.lazy="user.email" placeholder="{{ __('Enter Your Email Address') }}"
                        required>
                    @error('user.email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-lg-6 col-12">
                    <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                    <div wire:ignore>
                        <input type="text"
                            class="form-control {{ $errors->has('user.phone_number') ? 'is-invalid' : '' }}"
                            id="phone_number" wire:model.lazy="user.phone_number"
                            placeholder="{{ __('Enter Your Phone Number') }}">
                    </div>
                    @error('user.phone_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

    </form>
</div>

@section('scripts')
@endsection
