<div>
    <form wire:submit.prevent="update" id="updateUserForm">

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" class="form-control {{ $errors->has('user.name') ? 'is-invalid' : '' }}"
                id="name" name="name" wire:model="user.name" placeholder="{{ __('Enter Your Name') }}"
                value="{{ old('user.name', $user->name) }}">
            @error('user.name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <input type="email" class="form-control {{ $errors->has('user.email') ? 'is-invalid' : '' }}"
                id="email" name="email" wire:model="user.email" placeholder="{{ __('Enter Your Email Address') }}"
                value="{{ old('user.email', $user->email) }}">
            @error('user.email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

    </form>
</div>
