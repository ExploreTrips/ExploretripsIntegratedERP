<form class="px-3" method="POST" action="{{ route('test.send.mail') }}" id="test_email">
    @csrf

    @foreach ($data as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12">
                <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter test email address">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" class="btn-create btn btn-primary">{{ __('Send') }}</button>
    </div>
</form>
