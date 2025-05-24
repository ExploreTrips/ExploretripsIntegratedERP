    <form method="POST" action="{{ route('document.store') }}" class='needs-validation', novalidate>
        @csrf

    <div class="modal-body">

    <div class="row">
        <div class="form-group col-12">
            <label for="name" class="form-label">{{ __('Name') }}<x-required></x-required></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Enter Document Name') }}" required>
            @error('name')
            <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-12">
            <label for="is_required" class="form-label">{{ __('Required Field') }}<x-required></x-required></label>

            <select class="form-control" required name="is_required">
                <option value="">{{ __('Select') }}</option>
                <option value="1">{{__('Is Required')}}</option>
                <option value="0">{{__('Not Required')}}</option>
            </select>
        </div>

    </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn  btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
    </div>
</form>

