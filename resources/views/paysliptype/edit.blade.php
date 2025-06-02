<form action="{{ route('paysliptype.update', $paysliptype->id) }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="form-label">
                        {{ __('Name') }}<x-required></x-required>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $paysliptype->name) }}" class="form-control" placeholder="{{ __('Enter Department Name') }}" required>
                    @error('name')
                        <span class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
    </div>
</form>
