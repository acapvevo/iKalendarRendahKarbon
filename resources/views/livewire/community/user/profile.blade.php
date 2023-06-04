<div>
    <form wire:submit.prevent="update" id="updateUserForm">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control {{ $errors->has('user.name') ? 'is-invalid' : '' }}" id="name"
                name="name" wire:model="user.name" placeholder="Enter Your Name"
                value="{{ old('user.name', $user->name) }}" required oninput="this.value = this.value.toUpperCase()">
            @error('user.name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Identification Card (I/C) Number</label>
            <input type="text"
                class="form-control {{ $errors->has('user.identification_number') ? 'is-invalid' : '' }}"
                id="identification_number" name="identification_number" wire:model="user.identification_number"
                placeholder="Enter Your Identification Card (I/C) Number"
                value="{{ old('user.identification_number', $user->identification_number) }}" required>
            <div class="invalid-feedback" id="invalid-ic" style="display: none;">
                Your I/C Number is NOT valid
            </div>
            @error('user.identification_number')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control {{ $errors->has('user.phone_number') ? 'is-invalid' : '' }}"
                id="phone_number" name="phone_number" wire:model="user.phone_number"
                placeholder="Enter Your Phone Number" value="{{ old('user.phone_number', $user->phone_number) }}"
                required>
            <div class="invalid-feedback" id="alert-error-phoneNumber" style="display: none;">
                Your Phone Number in NOT valid
            </div>
            @error('user.phone_number')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Addres</label>
            <input type="email" class="form-control {{ $errors->has('user.email') ? 'is-invalid' : '' }}"
                id="email" name="email" wire:model="user.email" placeholder="Enter Your Email Address"
                value="{{ old('user.email', $user->email) }}">
            @error('user.email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

    </form>
</div>
