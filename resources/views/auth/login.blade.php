@extends('layouts.auth')
@php
    use App\Models\Utility;
    $logo = \App\Models\Utility::get_file('uploads/logo');
    $settings = Utility::settings();
    $company_logo = $settings['company_logo'] ?? '';
@endphp

@push('custom-scripts')
    @if ($settings['recaptcha_module'] == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush

@section('page-title')
    {{ __('Login') }}
@endsection

@if ($settings['cust_darklayout'] == 'on')
    <style>
        .g-recaptcha {
            filter: invert(1) hue-rotate(180deg) !important;
        }
    </style>
@endif

@php
    $languages = App\Models\Utility::languages();
@endphp

@section('language-bar')
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="drp-text"> {{ $languages[$lang] }}
                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                @foreach ($languages as $code => $language)
                    <a href="{{ route('login', $code) }}"
                        class="dropdown-item @if ($lang == $code) text-primary @endif">
                        <span>{{ Str::upper($language) }}</span>
                    </a>
                @endforeach
            </div>
        </li>
    </div>
@endsection

@section('content')
    <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
        <img src="{{ asset('login_template/img/auth-login-illustration-light.png')}}" class="auth-cover-illustration w-100" alt="auth-illustration" data-app-light-img="img/auth-login-illustration-light.png" data-app-dark-img="img/auth-login-illustration-dark.png">
        <img alt="mask" src="{{ asset('login_template/img/auth-basic-login-mask-light.png')}}" class="authentication-image d-none d-lg-block" data-app-light-img="img/auth-basic-login-mask-light.png" data-app-dark-img="img/auth-basic-login-mask-dark.png">
    </div>
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
        <div class="w-px-400 mx-auto pt-12 pt-lg-0">
            <h4 class="mb-3 f-w-600 text-center">{{ __('Login') }}</h4>
            <form action="{{ route('login') }}" method="POST" id="loginForm" class="login-form needs-validation" novalidate>
                @csrf
                @if (session('status'))
                    <div class="mb-4 font-medium text-lg text-green-600 text-danger">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="custom-login-form">
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="text" name="email" class="form-control" placeholder="{{ __('Enter Your Email') }}"
                            required>
                        @error('email')
                            <span class="error invalid-email text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="{{ __('Enter Your Password') }}" id="input-password" required>
                        @error('password')
                            <span class="error invalid-password text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            @if (Route::has('password.request'))
                                <span>
                                    <a href="{{ route('password.request', $lang) }}">{{ __('Forgot your password?') }}</a>
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($settings['recaptcha_module'] == 'on')
                        @if (isset($settings['google_recaptcha_version']) && $settings['google_recaptcha_version'] == 'v2-checkbox')
                            <div class="form-group col-lg-12 col-md-12 mt-3">
                                {!! NoCaptcha::display() !!}
                                @error('g-recaptcha-response')
                                    <span class="small text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @else
                            <div class="form-group col-lg-12 col-md-12 mt-3">
                                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response"
                                    class="form-control">
                                @error('g-recaptcha-response')
                                    <span class="error small text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                    @endif

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary mt-2" id="saveBtn">{{ __('Login') }}</button>
                    </div>

                    @if ($settings['enable_signup'] == 'on')
                        <p class="my-4 text-center">{{ __('Don\'t have an account?') }}
                            <a href="{{ route('register', $lang) }}" class="text-primary">{{ __('Register') }}</a>
                        </p>
                    @endif
                </div>
            </form>
            <div class="divider my-5">
                <div class="divider-text">or</div>
            </div>
            <div class="d-flex justify-content-center gap-2">
                <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook">
                    <i class="icon-base ri  ri-facebook-fill icon-18px"></i>
                </a>

                <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter">
                    <i class="icon-base ri  ri-twitter-fill icon-18px"></i>
                </a>

                <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github">
                    <i class="icon-base ri  ri-github-fill icon-18px"></i>
                </a>

                <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
                    <i class="icon-base ri  ri-google-fill icon-18px"></i>
                </a>
            </div>
        </div>
    </div>
        <!-- <div>
            <h2 class="mb-3 f-w-600 text-center">{{ __('Login') }}</h2>
        </div> -->
        <!-- <form action="{{ route('login') }}" method="POST" id="loginForm" class="login-form needs-validation" novalidate>
            @csrf
            @if (session('status'))
                <div class="mb-4 font-medium text-lg text-green-600 text-danger">
                    {{ session('status') }}
                </div>
            @endif

            <div class="custom-login-form">
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="text" name="email" class="form-control" placeholder="{{ __('Enter Your Email') }}"
                        required>
                    @error('email')
                        <span class="error invalid-email text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="{{ __('Enter Your Password') }}" id="input-password" required>
                    @error('password')
                        <span class="error invalid-password text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        @if (Route::has('password.request'))
                            <span>
                                <a href="{{ route('password.request', $lang) }}">{{ __('Forgot your password?') }}</a>
                            </span>
                        @endif
                    </div>
                </div>

                @if ($settings['recaptcha_module'] == 'on')
                    @if (isset($settings['google_recaptcha_version']) && $settings['google_recaptcha_version'] == 'v2-checkbox')
                        <div class="form-group col-lg-12 col-md-12 mt-3">
                            {!! NoCaptcha::display() !!}
                            @error('g-recaptcha-response')
                                <span class="small text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @else
                        <div class="form-group col-lg-12 col-md-12 mt-3">
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response"
                                class="form-control">
                            @error('g-recaptcha-response')
                                <span class="error small text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
                @endif

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary mt-2" id="saveBtn">{{ __('Login') }}</button>
                </div>

                @if ($settings['enable_signup'] == 'on')
                    <p class="my-4 text-center">{{ __('Don\'t have an account?') }}
                        <a href="{{ route('register', $lang) }}" class="text-primary">{{ __('Register') }}</a>
                    </p>
                @endif
            </div>
        </form> -->
    <!-- </div> -->
@endsection

@if (isset($settings['recaptcha_module']) && $settings['recaptcha_module'] == 'on')
    @if (isset($settings['google_recaptcha_version']) && $settings['google_recaptcha_version'] == 'v2-checkbox')
        {!! NoCaptcha::renderJs() !!}
    @else
        <script src="https://www.google.com/recaptcha/api.js?render={{ $settings['google_recaptcha_key'] }}"></script>
        <script>
            $(document).ready(function() {
                grecaptcha.ready(function() {
                    grecaptcha.execute('{{ $settings['google_recaptcha_key'] }}', {
                        action: 'submit'
                    }).then(function(token) {
                        $('#g-recaptcha-response').val(token);
                    });
                });
            });
        </script>
    @endif
@endif
