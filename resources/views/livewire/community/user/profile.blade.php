<div>
    <form wire:submit.prevent="update" id="updateUserForm">

        <div class="pt-3 pb-3">
            <hr>
            <h5 class="text-center">PROFILE</h5>
            <hr>
        </div>

        <div class="mb-3 row">
            <div class="col-lg-6 col-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control {{ $errors->has('user.name') ? 'is-invalid' : '' }}"
                    id="name" name="name" wire:model="user.name" placeholder="Enter Your Name"
                    value="{{ old('user.name', $user->name) }}" required
                    oninput="this.value = this.value.toUpperCase()">
                @error('user.name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-lg-6 col-12">
                <label for="identification_number" class="form-label">Identification Card (I/C) Number</label>
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
        </div>

        <div class="mb-3 row">
            <div class="col-lg-6 col-12">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control {{ $errors->has('user.email') ? 'is-invalid' : '' }}"
                    id="email" name="email" wire:model="user.email" placeholder="Enter Your Email Address"
                    value="{{ old('user.email', $user->email) }}" required>
                @error('user.email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-lg-6 col-12">
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
        </div>

        <div class="pt-3 pb-3">
            <hr>
            <h5 class="text-center">ADDRESS</h5>
            <hr>
        </div>

        <div class="mb-3 row">
            <div class="col-12 col-lg-4">
                <label for="address.line_1" class="form-label">Address Line 1</label>
                <input type="text" class="form-control {{ $errors->has('address.line_1') ? 'is-invalid' : '' }}"
                    id="address.line_1" name="address[line_1]" wire:model="address.line_1" placeholder="Enter Your Address Line 1"
                    value="{{ old('address.line_1', $address->line_1) }}" required>
                @error('address.line_1')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12 col-lg-4">
                <label for="address.line_2" class="form-label">Address Line 2</label>
                <input type="text" class="form-control {{ $errors->has('address.line_2') ? 'is-invalid' : '' }}"
                    id="address.line_2" name="address[line_2]" wire:model="address.line_2" placeholder="Enter Your Address Line 2"
                    value="{{ old('address.line_2', $address->line_2) }}" required>
                @error('address.line_2')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12 col-lg-4">
                <label for="address.line_3" class="form-label">Address Line 3</label>
                <input type="text" class="form-control {{ $errors->has('address.line_3') ? 'is-invalid' : '' }}"
                    id="address.line_3" name="address[line_3]" wire:model="address.line_3" placeholder="Enter Your Address Line 3"
                    value="{{ old('address.line_3', $address->line_3) }}">
                @error('address.line_3')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col-12 col-lg-6">
                <label for="address.postcode" class="form-label">Postcode</label>
                <input type="text" class="form-control {{ $errors->has('address.postcode') ? 'is-invalid' : '' }}"
                    id="address.postcode" name="address[postcode]" wire:model="address.postcode" placeholder="Enter Your Postcode"
                    value="{{ old('address.postcode', $address->postcode) }}" required>
                @error('address.postcode')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12 col-lg-6">
                <label for="address.city" class="form-label">City</label>
                <input type="text" class="form-control {{ $errors->has('address.city') ? 'is-invalid' : '' }}"
                    id="address.city" name="address[city]" wire:model="address.city" placeholder="Enter Your City"
                    value="{{ old('address.city', $address->city) }}"required>
                @error('address.city')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col-12 col-lg-6">
                <label for="address.state" class="form-label">State</label>
                <input type="text" class="form-control {{ $errors->has('address.state') ? 'is-invalid' : '' }}"
                    id="address.state" name="address[state]" wire:model="address.state" placeholder="Enter Your State"
                    value="{{ old('address.state', $address->state) }}" readonly required>
                @error('address.state')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12 col-lg-6">
                <label for="address.country" class="form-label">Country</label>
                <input type="text" class="form-control {{ $errors->has('address.country') ? 'is-invalid' : '' }}"
                    id="address.country" name="address[country]" wire:model="address.country" placeholder="Enter Your Country"
                    value="{{ old('address.country', $address->country) }}" readonly required>
                @error('address.country')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

    </form>
</div>
