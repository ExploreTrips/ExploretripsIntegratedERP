<form action="{{ route('users.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="container">
        <div class="row justify-content-center mt-5">
            {{-- Name --}}
            <div class="col-md-5">
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Name') }} <x-required /></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="form-control font-style" placeholder="{{ __('Enter User Name') }}" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="col-md-5">
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }} <x-required /></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="form-control" placeholder="{{ __('Enter User Email') }}" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Role --}}
        @if(Auth::user()->type != 'super admin')
            <div class="row justify-content-center mt-3">
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="role" class="form-label">{{ __('User Role') }} <x-required /></label>
                        <select name="role" id="role" class="form-control select" required>
                            @foreach($roles as $id => $roleName)
                                <option value="{{ $id }}" {{ in_array($id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $roleName }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        {{-- Custom Fields --}}
        @if(!$customFields->isEmpty())
            <div class="row justify-content-center mt-3">
                <div class="col-md-10">
                    @include('customFields.formBuilder')
                </div>
            </div>
        @endif
    </div>


    {{-- Modal Footer --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </div>
</form>
