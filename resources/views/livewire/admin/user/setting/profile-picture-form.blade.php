<div>
    <form wire:submit.prevent="update" enctype="multipart/form-data">

        <div class="mb-3">
            <img width="200" height="200" class="img-fluid rounded-circle mx-auto d-block"
                src="{{ isset(Auth::user()->image) ? route('admin.user.picture.show') : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png' }}" />
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Profile Picture</label>
            <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file"
                id="image" name="image" wire:model="image">
            @error('image')
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
