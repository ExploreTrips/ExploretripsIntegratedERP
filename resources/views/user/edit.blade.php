<form action="{{ route('users.update', $user->id) }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="container">
        {{-- Row 1: Name & Email --}}
        <div class="row justify-content-center mt-4">
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
            <div class="row justify-content-center mt-4">
                <div class="col-md-5">
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
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="avatar" class="form-label">{{ __('Profile Image') }}</label>
                        <input type="file" name="avatar" id="avatar" class="form-control" onchange="previewAvatar(event)">
                        @if($user->avatar)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $user->avatar) }}" id="avatar-preview" alt="avatar" width="120"  height='120' class="rounded border">
                                {{-- <img id="avatar-preview" src="#" alt="Avatar Preview" style="display:none; margin-top:10px; max-height: 100px;" /> --}}
                            </div>
                        @endif
                        @error('avatar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        @endif


        {{-- Password --}}
        {{-- <div class="row justify-content-center mt-4">
            <div class="col-md-10">
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" name="password" id="password" class="form-control" value="{{ old('password',$user->password) }}"
                        placeholder="{{ __('Update Password') }}" minlength="6">
                    @error('password')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div> --}}


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
    <div class="modal-footer mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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
