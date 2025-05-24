<form action="{{ url('branch') }}" method="POST" class="needs-validation" novalidate>
    @csrf

    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="name">{{ __('Name') }}<x-required/></label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="{{ __('Enter Branch Name') }}"
                           value="{{ old('name') }}"
                           required
                           aria-describedby="nameError">

                    @error('name')
                    <div class="invalid-feedback" id="nameError">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
    </div>
</form>

