<form action="{{ url('clients') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="form-group">
                <label for="name" class="form-label">{{ __('Name') }}<x-required></x-required></label>
                <input type="text" name="name" id="name" class="form-control"
                    placeholder="{{ __('Enter client Name') }}" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">{{ __('E-Mail Address') }}<x-required></x-required></label>
                <input type="email" name="email" id="email" class="form-control"
                    placeholder="{{ __('Enter Client Email') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="avatar">
                    {{ __('Upload Avatar') }} <x-required />
                </label>
                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*"
                    onchange="previewAvatar(event)">

                <div class="d-flex justify-content-center">
                    <img id="avatar-preview" src="#" alt="Avatar Preview"
                        style="display:none; margin-top:10px; max-height: 100px;" />
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
                        value="on" id="password_switch">
                    <label class="form-check-label" for="password_switch"></label>
                </div>
            </div>

            <div class="col-md-12 ps_div d-none">
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}<x-required></x-required></label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="{{ __('Enter Client Password') }}" minlength="6">
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
        <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
    </div>
</form>
<script>
    function previewAvatar(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('avatar-preview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>
