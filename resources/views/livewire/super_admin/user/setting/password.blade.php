<div>
    <form wire:submit.prevent="update">

        <div class="mb-3">
            <label class="form-label" for="password">New Password</label>
            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password"
                type="password" placeholder="Enter your New Password" name="password" wire:model="password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="password_confirmation">New Password Confirmation</label>
            <input class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                id="password_confirmation" type="password" placeholder="Enter your New Password Again"
                name="password_confirmation" wire:model="password_confirmation">
            @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <button class="btn btn-primary float-end" type="submit">Update</button>
        </div>
    </form>
</div>
