<form action="{{ url('users') }}" method="POST" class="needs-validation" novalidate  enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="row">
            @if (Auth::user()->type == 'super admin')
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="name">{{ __('Name') }} <x-required /></label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="{{ __('Enter Company Name') }}" required>
                        @error('name')
                            <small class="invalid-name" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="email">{{ __('Email') }} <x-required /></label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="{{ __('Enter Company Email') }}" required>
                        @error('email')
                            <small class="invalid-email" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>

                <input type="hidden" name="role" value="company">

                <div class="col-md-6 mb-3 form-group mt-4">
                    <label for="password_switch">{{ __('Login is enable') }}</label>
                    <div class="form-check form-switch custom-switch-v1 float-end">
                        <input type="checkbox" name="password_switch" class="form-check-input input-primary pointer"
                            value="on" id="password_switch">
                        <label class="form-check-label" for="password_switch"></label>
                    </div>
                </div>

                <div class="col-md-6 ps_div d-none">
                    <div class="form-group">
                        <label class="form-label" for="password">{{ __('Password') }} <x-required /></label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="{{ __('Enter Company Password') }}" minlength="6">
                        @error('password')
                            <small class="invalid-password" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
            @else
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="name">{{ __('Name') }} <x-required /></label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="{{ __('Enter User Name') }}" required>
                        @error('name')
                            <small class="invalid-name" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="email">{{ __('Email') }} <x-required /></label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="{{ __('Enter User Email') }}" required>
                        @error('email')
                            <small class="invalid-email" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label class="form-label" for="avatar">{{ __('Upload Avatar') }}<x-required /></label>
                        <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*" onchange="previewAvatar(event)">
                        <img id="avatar-preview" src="#" alt="Avatar Preview" style="display:none; margin-top:10px; max-height: 100px;" />
                        @error('avatar')
                            <small class="invalid-avatar" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label" for="role">{{ __('User Role') }} <x-required /></label>
                    <select name="role" id="role" class="form-control select" required>
                        @foreach ($roles as $id => $roleName)
                            <option value="{{ $id }}">{{ $roleName }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <small class="invalid-role" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="password_switch">{{ __('Login is enabled') }}</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" name="password_switch" class="form-check-input pointer"
                            value="on" id="password_switch">
                        <label class="form-check-label ms-2" for="password_switch">{{ __('Enable login') }}</label>
                    </div>
                </div>

                <div class="col-md-6 ps_div d-none">
                    <div class="form-group">
                        <label class="form-label" for="password">{{ __('Password') }} <x-required /></label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="{{ __('Enter Company Password') }}" minlength="6">
                        @error('password')
                            <small class="invalid-password" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
            @endif

            @if (!$customFields->isEmpty())
                <div class="col-md-6">
                    <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                        @include('customFields.formBuilder')
                    </div>
                </div>
            @endif
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

