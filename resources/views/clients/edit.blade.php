<form action="{{ url('clients/' . $client->id) }}" method="POST" class="needs-validation" novalidate
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="form-group">
                <label for="name" class="form-label">{{ __('Name') }}<x-required></x-required></label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $client->name) }}" placeholder="{{ __('Enter client Name') }}" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">{{ __('E-Mail Address') }}<x-required></x-required></label>
                <input type="email" name="email" id="email" class="form-control"
                    value="{{ old('email', $client->email) }}" placeholder="{{ __('Enter Client Email') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="avatar">
                    {{ __('Upload Avatar') }} <x-required />
                </label>
                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*"
                    onchange="previewAvatar(event)">

                {{-- Current avatar --}}
                <div class="d-flex justify-content-center mt-3">
                    <img id="current-avatar"
                        src="{{ !empty($client->avatar) ? \App\Models\Utility::get_file($client->avatar) : asset(Storage::url('avatars/__avatar.png')) }}"
                        class="shadow rounded" width="120" height="120" alt="Current Avatar">
                </div>

                {{-- Preview of new avatar (hidden by default) --}}
                <div class="d-flex justify-content-center mt-3">
                    <img id="avatar-preview" src="#" alt="Avatar Preview"
                        style="display: none; max-height: 120px;" class="shadow rounded" />
                </div>

                @error('avatar')
                    <small class="invalid-avatar" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>




            <div class="col-md-8 form-group">
                <label for="password_switch">{{ __('Login is enable') }}</label>
                <div class="form-check form-switch custom-switch-v1 float-end">
                    <input type="checkbox" name="password_switch" class="form-check-input input-primary pointer"
                        value="on" id="password_switch"
                        {{ old('password_switch', $client->is_enable_login === 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="password_switch"></label>
                </div>
            </div>

            <div class="col-md-12 ps_div d-none">
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="{{ __('Enter New Password (if changing)') }}" minlength="6">
                    @error('password')
                        <small class="invalid-password" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
            </div>

            {{-- @if (!$customFields->isEmpty())
                @include('custom_fields.formBuilder')
            @endif --}}
        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
    </div>
</form>

<script>
    function previewAvatar(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('avatar-preview');
            const current = document.getElementById('current-avatar');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            if (current) {
                current.style.display = 'none';
            }
        }
    }
</script>
