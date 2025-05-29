<form action="{{ route('client.password.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
    @csrf
    <div class="modal-body" id="resetPasswordModal">
        <div class="row">
        <div class="form-group">
    <label for="password">{{ __('Password') }}</label>
    <div class="input-group">
        <input id="password" type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password" required autocomplete="new-password"
               placeholder="{{ __('Enter Password') }}">
        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', this)">
            <i class="fa fa-eye"></i>
        </button>
    </div>
    @error('password')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
    <div class="input-group">
        <input id="password_confirmation" type="password"
               class="form-control @error('password_confirmation') is-invalid @enderror"
               name="password_confirmation" required autocomplete="new-password"
               placeholder="{{ __('Enter Confirm Password') }}">
        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation', this)">
            <i class="fa fa-eye"></i>
        </button>
    </div>
    @error('password_confirmation')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>




        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Reset') }}" class="btn btn-primary">
    </div>
</form>

<script>
    function togglePassword(fieldId, el) {
        const input = document.getElementById(fieldId);
        const icon = el.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>


