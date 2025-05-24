<form action="{{ route('document.update', $document->id) }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Name') }} <x-required /></label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $document->name) }}"
                           placeholder="{{ __('Enter Department Name') }}"
                           required>
                    @error('name')
                        <span class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="is_required" class="form-label">{{ __('Required Field') }} <x-required /></label>
                    <select class="form-control" id="is_required" name="is_required" required>
                        <option value="0" {{ $document->is_required == 0 ? 'selected' : '' }}>{{ __('Not Required') }}</option>
                        <option value="1" {{ $document->is_required == 1 ? 'selected' : '' }}>{{ __('Is Required') }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
    </div>
</form>
