<div class="col-md-12">
    <div class="form-group">
        <label for="phone" class="form-label">Phone</label>
<span class="text-danger">*</span>

<input
    type="text"
    name="phone"
    {{-- value="+919876543210" --}}
    class="form-control"
    placeholder="Enter phone number with country code"
    pattern="^\+\d{1,3}\d{9,13}$"
    id="phone"
    required
>

        {{-- <div class=" text-xs text-danger">
            {{ __('Please use with country code. (ex. +91)') }}
        </div> --}}
    </div>
</div>
