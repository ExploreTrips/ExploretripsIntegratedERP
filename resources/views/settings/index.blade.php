@extends('layouts.admin')
@section('page-title')
    {{ __('Settings') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Settings') }}</li>
@endsection

@php
    $lang = \App\Models\Utility::getValByName('default_language');
    $logo = asset(Storage::url('uploads/logo/'));
    // $logo = \App\Models\Utility::get_file('uploads/logo');

    // dd($logo);

    $logo_light = \App\Models\Utility::getValByName('logo_light');
    $logo_dark = \App\Models\Utility::getValByName('logo_dark');
    $company_favicon = \App\Models\Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
    $flag = !empty($setting['color_flag']) ? $setting['color_flag'] : '';
    $SITE_RTL = isset($setting['SITE_RTL']) ? $setting['SITE_RTL'] : 'off';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $google_recaptcha_version = ['v2-checkbox' => __('v2'), 'v3' => __('v3')];
    $languages = \App\Models\Utility::languages();
    $footer_text = \App\Models\Utility::getValByName('footer_text');
@endphp

{{-- Storage setting --}}
@php
    $file_type = config('files_types');
    $setting = App\Models\Utility::settings();

    $local_storage_validation = $setting['local_storage_validation'];
    $local_storage_validations = explode(',', $local_storage_validation);

    $s3_storage_validation = $setting['s3_storage_validation'];
    $s3_storage_validations = explode(',', $s3_storage_validation);

    $wasabi_storage_validation = $setting['wasabi_storage_validation'];
    $wasabi_storage_validations = explode(',', $wasabi_storage_validation);

@endphp
<style>
    .color-wrp {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        align-items: center;
    }

    .themes-color {
        display: grid;
        grid-template-columns: repeat(5, 40px);
        gap: 10px;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .themes-color-change {
        display: inline-block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease-in-out;
    }

    .themes-color-change.active_color {
        border-color: #000;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    /* Example Theme Colors */
    .themes-color-change[data-value="theme-1"] {
        background-color: #4CAF50;
    }

    .themes-color-change[data-value="theme-2"] {
        background-color: #2196F3;
    }

    .themes-color-change[data-value="theme-3"] {
        background-color: #FF9800;
    }

    .themes-color-change[data-value="theme-4"] {
        background-color: #9C27B0;
    }

    .themes-color-change[data-value="theme-5"] {
        background-color: #F44336;
    }

    .themes-color-change[data-value="theme-6"] {
        background-color: #00BCD4;
    }

    .themes-color-change[data-value="theme-7"] {
        background-color: #795548;
    }

    .themes-color-change[data-value="theme-8"] {
        background-color: #607D8B;
    }

    .themes-color-change[data-value="theme-9"] {
        background-color: #E91E63;
    }

    .themes-color-change[data-value="theme-10"] {
        background-color: #3F51B5;
    }

    .color-picker-wrp {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .colorPicker {
        width: 50px;
        height: 50px;
        border: none;
        padding: 0;
        border-radius: 50%;
        cursor: pointer;
    }

    .colorPicker.active_color {
        border: 3px solid #000;
    }
</style>
,

<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     const body = document.querySelector("body");
    //     const input = document.getElementById("colorPicker");
    //     const colorCode = document.getElementById("colorCode");
    //     const button = document.getElementById("
    // changeColorButton");

    //     setColor();
    //     input.addEventListener("input", setColor);

    //     function setColor() {
    //         // body.style.backgroundColor = input.value;
    //         colorCode.innerHTML = input.value;
    //     }
    // });
</script>
{{-- end Storage setting --}}
@push('css-page')
    @if ($color == 'theme-3')
        <style>
            .btn-check:checked+.btn-outline-primary,
            .btn-check:active+.btn-outline-primary,
            .btn-outline-primary:active,
            .btn-outline-primary.active,
            .btn-outline-primary.dropdown-toggle.show {
                color: #ffffff;
                background-color: #6fd943 !important;
                border-color: #6fd943 !important;
            }

            .btn-outline-primary:hover {
                color: #ffffff;
                background-color: #6fd943 !important;
                border-color: #6fd943 !important;
            }

            .btn[class*="btn-outline-"]:hover {

                border-color: #6fd943 !important;
            }
        </style>
    @endif
    @if ($color == 'theme-2')
        <style>
            .btn-check:checked+.btn-outline-primary,
            .btn-check:active+.btn-outline-primary,
            .btn-outline-primary:active,
            .btn-outline-primary.active,
            .btn-outline-primary.dropdown-toggle.show {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
                border-color: #4ebbd3 !important;
            }

            .btn-outline-primary:hover {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
                border-color: #4ebbd3 !important;
            }

            .btn.btn-outline-primary {
                color: #1F3996;
                border-color: #4ebbd3 !important;
            }
        </style>
    @endif
    @if ($color == 'theme-4')
        <style>
            .btn-check:checked+.btn-outline-primary,
            .btn-check:active+.btn-outline-primary,
            .btn-outline-primary:active,
            .btn-outline-primary.active,
            .btn-outline-primary.dropdown-toggle.show {
                color: #ffffff;
                background-color: #584ed2 !important;
                border-color: #584ed2 !important;

            }

            .btn-outline-primary:hover {
                color: #ffffff;
                background-color: #584ed2 !important;
                border-color: #584ed2 !important;
            }

            .btn.btn-outline-primary {
                color: #584ed2;
                border-color: #584ed2 !important;
            }
        </style>
    @endif
    @if ($color == 'theme-1')
        <style>
            .btn-check:checked+.btn-outline-primary,
            .btn-check:active+.btn-outline-primary,
            .btn-outline-primary:active,
            .btn-outline-primary.active,
            .btn-outline-primary.dropdown-toggle.show {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
                border-color: #51459d !important;
            }


            body.theme-1 .btn-outline-primary:hover {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
                border-color: #51459d !important;
            }
        </style>
    @endif
@endpush


@push('script-page')
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300,
        })

        $('.colorPicker').on('click', function(e) {
            $('body').removeClass('custom-color');
            if (/^theme-\d+$/) {
                $('body').removeClassRegex(/^theme-\d+$/);
            }
            $('body').addClass('custom-color');
            $('.themes-color-change').removeClass('active_color');
            $(this).addClass('active_color');
            const input = document.getElementById("color-picker");
            setColor();
            input.addEventListener("input", setColor);

            function setColor() {
                $(':root').css('--color-customColor', input.value);
            }

            $(`input[name='color_flag`).val('true');
        });

        $('.themes-color-change').on('click', function() {

            $(`input[name='color_flag`).val('false');

            var color_val = $(this).data('value');
            $('body').removeClass('custom-color');
            if (/^theme-\d+$/) {
                $('body').removeClassRegex(/^theme-\d+$/);
            }
            $('body').addClass(color_val);
            $('.theme-color').prop('checked', false);
            $('.themes-color-change').removeClass('active_color');
            $('.colorPicker').removeClass('active_color');
            $(this).addClass('active_color');
            $(`input[value=${color_val}]`).prop('checked', true);
        });

        $.fn.removeClassRegex = function(regex) {
            return $(this).removeClass(function(index, classes) {
                return classes.split(/\s+/).filter(function(c) {
                    return regex.test(c);
                }).join(' ');
            });
        };

        // storage setting
        $(document).on('change', '[name=storage_setting]', function() {
            if ($(this).val() == 's3') {
                $('.s3-setting').removeClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').addClass('d-none');
            } else if ($(this).val() == 'wasabi') {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').removeClass('d-none');
                $('.local-setting').addClass('d-none');
            } else {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').removeClass('d-none');
            }
        });
    </script>

    <script>
        document.getElementById('logo_dark').onchange = function() {
            var src = URL.createObjectURL(this.files[0])
            document.getElementById('image').src = src
        }
        document.getElementById('logo_light').onchange = function() {
            var src = URL.createObjectURL(this.files[0])
            document.getElementById('image1').src = src
        }
        document.getElementById('favicon').onchange = function() {
            var src = URL.createObjectURL(this.files[0])
            document.getElementById('image2').src = src
        }
    </script>

    <script type="text/javascript">
        $(document).on("click", '.send_email', function(e) {
            e.preventDefault();
            var title = $(this).attr('data-title');
            var size = 'md';
            var url = $(this).attr('data-url');

            if (typeof url != 'undefined') {
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $("#commonModal").modal('show');


                $.post(url, {
                    _token: '{{ csrf_token() }}',
                    mail_driver: $("#mail_driver").val(),
                    mail_host: $("#mail_host").val(),
                    mail_port: $("#mail_port").val(),
                    mail_username: $("#mail_username").val(),
                    mail_password: $("#mail_password").val(),
                    mail_encryption: $("#mail_encryption").val(),
                    mail_from_address: $("#mail_from_address").val(),
                    mail_from_name: $("#mail_from_name").val(),

                }, function(data) {
                    $('#commonModal .modal-body').html(data);
                });
            }
        });
        $(document).on('submit', '#test_email', function(e) {
            e.preventDefault();
            // $("#email_sending").show();
            var post = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: url,
                data: post,
                cache: false,
                beforeSend: function() {
                    $('#test_email .btn-create').attr('disabled', 'disabled');
                },
                success: function(data) {
                    // console.log(data)
                    if (data.success) {
                        show_toastr('success', data.message, 'success');
                    } else {
                        show_toastr('error', data.message, 'error');
                    }
                    // $("#email_sending").hide();
                    $('#commonModal').modal('hide');


                },
                complete: function() {
                    $('#test_email .btn-create').removeAttr('disabled');
                },
            });
        });
    </script>

    {{--    for cookie setting --}}
    <script type="text/javascript">
        function enablecookie() {
            const element = $('#enable_cookie').is(':checked');
            $('.cookieDiv').addClass('disabledCookie');
            if (element == true) {
                $('.cookieDiv').removeClass('disabledCookie');
                $("#cookie_logging").attr('checked', true);
            } else {
                $('.cookieDiv').addClass('disabledCookie');
                $("#cookie_logging").attr('checked', false);
            }
        }
    </script>

    <script>
        if ($('#cust-darklayout').length > 0) {
            var custthemedark = document.querySelector("#cust-darklayout");
            custthemedark.addEventListener("click", function() {
                if (custthemedark.checked) {
                    $('#main-style-link').attr('href', '{{ config('app.url') }}' +
                        '/public/assets/css/style-dark.css');
                    document.body.style.background = 'linear-gradient(141.55deg, #22242C 3.46%, #22242C 99.86%)';

                    $('.dash-sidebar .main-logo a img').attr('src',
                        '{{ isset($logo_light) && !empty($logo_light) ? $logo . $logo_light : $logo . '/logo-light.png' }}'
                    );

                } else {
                    $('#main-style-link').attr('href', '{{ config('app.url') }}' + '/public/assets/css/style.css');
                    document.body.style.setProperty('background',
                        'linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #f0f4f3 99.86%)', 'important');

                    $('.dash-sidebar .main-logo a img').attr('src',
                        '{{ isset($logo_light) && !empty($logo_light) ? $logo . $logo_light : $logo . '/logo-dark.png' }}'
                    );

                }
            });
        }

        if ($('#cust-theme-bg').length > 0) {
            var custthemebg = document.querySelector("#cust-theme-bg");
            custthemebg.addEventListener("click", function() {
                if (custthemebg.checked) {
                    document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                    document
                        .querySelector(".dash-header:not(.dash-mob-header)")
                        .classList.add("transprent-bg");
                } else {
                    document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                    document
                        .querySelector(".dash-header:not(.dash-mob-header)")
                        .classList.remove("transprent-bg");
                }
            });
        }
    </script>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Settings') }}</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#brand-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Brand Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#email-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Email Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#payment-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Payment Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    {{--  Start for all settings tab --}}

                    <!--Site Settings-->
                    <div id="brand-settings" class="card">
                        <div class="card-header">
                            <h5>{{ __('Brand Settings') }}</h5>
                        </div>
                        <form action={{ url('systems') }} method='post' enctype='multipart/form-data'>
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card logo_card">
                                            <div class="card-header">
                                                <h5>{{ __('Logo dark') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="setting-card">
                                                    <div class="logo-content mt-4">
                                                        <img id="image"
                                                            src="{{ $logo . '/' . (isset($logo_dark) && !empty($logo_dark) ? $logo_dark : 'logo-dark.png') . '?timestamp=' . time() }}"
                                                            class="big-logo">

                                                        {{-- <img src="{{ asset('storage/uploads/logo/logo-dark.png') }}" alt="Logo" class="big-logo" id="image"> --}}

                                                    </div>
                                                    <div class="choose-files mt-5">
                                                        <label for="logo_dark">
                                                            <div class=" bg-primary company_logo_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file" name="logo_dark" id="logo_dark"
                                                                class="form-control file" data-filename="logo_dark">
                                                        </label>
                                                    </div>
                                                    @error('logo_dark')
                                                        <div class="row">
                                                            <span class="invalid-logo" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card logo_card">
                                            <div class="card-header">
                                                <h5>{{ __('Logo Light') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-4">
                                                        <img id="image1"
                                                            src="{{ $logo . '/' . (isset($logo_light) && !empty($logo_light) ? $logo_light : 'logo-light.png') . '?timestamp=' . time() }}"
                                                            class="big-logo img_setting">

                                                        {{-- <img src="{{ asset('storage/uploads/logo/logo-light.png') }}" alt="Logo" class="big-logo" id="image1"> --}}
                                                    </div>
                                                    <div class="choose-files mt-5">
                                                        <label for="logo_light">
                                                            <div class=" bg-primary dark_logo_update"> <i
                                                                    class="ti ti-upload px-1">
                                                                </i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file" name="logo_light" id="logo_light"
                                                                class="form-control file" data-filename="logo_light">
                                                        </label>
                                                    </div>
                                                    @error('logo_light')
                                                        <div class="row">
                                                            <span class="invalid-logo" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card logo_card">
                                            <div class="card-header">
                                                <h5>{{ __('Favicon') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-4">
                                                        <img id="image2"
                                                            src="{{ $logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') . '?timestamp=' . time() }}"
                                                            width="50px" class=" big-logo img_setting">
                                                    </div>
                                                    <div class="choose-files mt-5">
                                                        <label for="favicon">
                                                            <div class="bg-primary company_favicon_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file" class="form-control file"
                                                                id="favicon" name="favicon" data-filename="favicon">
                                                        </label>
                                                    </div>
                                                    @error('favicon')
                                                        <div class="row">
                                                            <span class="invalid-logo" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="title_text" class="form-label">{{ __('Title Text') }}</label>
                                                <input type="text" name="title_text" id="title_text"
                                                    class="form-control" placeholder="{{ __('Title Text') }}"
                                                    value="{{ old('title_text', $settings['title_text'] ?? '') }}">

                                                @error('title_text')
                                                    <span class="invalid-title_text" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="footer_text"
                                                    class="form-label">{{ __('Footer Text') }}</label>
                                                <input type="text" name="footer_text" id="footer_text"
                                                    class="form-control" placeholder="{{ __('Enter Footer Text') }}"
                                                    value="{{ old('footer_text', $footer_text) }}">
                                                @error('footer_text')
                                                    <span class="invalid-footer_text" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for='default_language' class='form-label'>
                                                    {{ __('Default Language') }}</label>
                                                <div class="changeLanguage">
                                                    <select name="default_language" id="default_language"
                                                        class="form-control select">
                                                        @foreach ($languages as $code => $language)
                                                            <option @if ($lang == $code) selected @endif
                                                                value="{{ $code }}">
                                                                {{ ucFirst($language) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('default_language')
                                                    <span class="invalid-default_language" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <div class="custom-control custom-switch">
                                                <label class="mb-1 mt-3" for="SITE_RTL">{{ __('Enable RTL') }}</label>
                                                <div class="">
                                                    <input type="checkbox" name="SITE_RTL" id="SITE_RTL"
                                                        data-toggle="switchbutton" data-onstyle="primary"
                                                        {{ $settings['SITE_RTL'] == 'on' ? 'checked="checked"' : '' }}>
                                                    <label class="custom-control-label" for="SITE_RTL"></label>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="mb-1 mt-3"
                                                for="display_landing_page">{{ __('Enable Landing Page') }}</label>
                                            <div class="">
                                                <input type="checkbox" name="display_landing_page"
                                                    class="form-check-input" id="display_landing_page"
                                                    data-toggle="switchbutton"
                                                    {{ \App\Models\Utility::getValByName('display_landing_page') == 'on' ? 'checked' : '' }}
                                                    data-onstyle="primary">
                                                <label class="form-check-label" for="display_landing_page"></label>
                                            </div>
                                        </div>
                                    </div> --}}

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="mb-1 mt-3"
                                                    for="signup_button">{{ __('Enable Sign-Up Page') }}</label>
                                                <div class="">
                                                    <input type="checkbox" name="enable_signup" id="enable_signup"
                                                        data-toggle="switchbutton"
                                                        {{ $settings['enable_signup'] == 'on' ? 'checked="checked"' : '' }}
                                                        data-onstyle="primary">
                                                    <label class="form-check-label" for="enable_signup"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="form-group">
                                                <label class="mb-1 mt-3"
                                                    for="email_verification">{{ __('Email Verification') }}</label>
                                                <div class="">
                                                    <input type="checkbox" name="email_verification"
                                                        id="email_verification" data-toggle="switchbutton"
                                                        {{ $settings['email_verification'] == 'on' ? 'checked="checked"' : '' }}
                                                        data-onstyle="primary">
                                                    <label class="form-check-label" for="email_verification"></label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <hr class="my-2" />
                                    <h4 class="small-title">{{ __('Theme Customizer') }}</h4>
                                    <div class="setting-card setting-logo-box p-3">
                                        <div class="row">
                                            <div class="col-lg-4 col-xl-4 col-md-4">
                                                <h6 class="mt-2">
                                                    <i data-feather="credit-card"
                                                        class="me-2"></i>{{ __('Primary color settings') }}
                                                </h6>

                                                <hr class="my-2" />
                                                <div class="color-wrp">
                                                    <div class="theme-color themes-color">
                                                        <a href="#!"
                                                            class="themes-color-change {{ $color == 'theme-1' ? 'active_color' : '' }}"
                                                            data-value="theme-1"></a>
                                                        <input type="radio" class="theme_color d-none" name="color"
                                                            value="theme-1"{{ $color == 'theme-1' ? 'checked' : '' }}>
                                                        <a href="#!"
                                                            class="themes-color-change {{ $color == 'theme-2' ? 'active_color' : '' }}"
                                                            data-value="theme-2"></a>
                                                        <input type="radio" class="theme_color d-none" name="color"
                                                            value="theme-2"{{ $color == 'theme-2' ? 'checked' : '' }}>
                                                        <a href="#!"
                                                            class="themes-color-change {{ $color == 'theme-3' ? 'active_color' : '' }}"
                                                            data-value="theme-3"></a>
                                                        <input type="radio" class="theme_color d-none" name="color"
                                                            value="theme-3"{{ $color == 'theme-3' ? 'checked' : '' }}>
                                                        <a href="#!"
                                                            class="themes-color-change {{ $color == 'theme-4' ? 'active_color' : '' }}"
                                                            data-value="theme-4"></a>
                                                        <input type="radio" class="theme_color d-none" name="color"
                                                            value="theme-4"{{ $color == 'theme-4' ? 'checked' : '' }}>
                                                        <a href="#!"
                                                            class="themes-color-change {{ $color == 'theme-5' ? 'active_color' : '' }}"
                                                            data-value="theme-5"></a>
                                                        <input type="radio" class="theme_color d-none" name="color"
                                                            value="theme-5"{{ $color == 'theme-5' ? 'checked' : '' }}>
                                                        <br>
                                                        <a href="#!"
                                                            class="themes-color-change {{ $color == 'theme-6' ? 'active_color' : '' }}"
                                                            data-value="theme-6"></a>
                                                        <input type="radio" class="theme_color d-none" name="color"
                                                            value="theme-6"{{ $color == 'theme-6' ? 'checked' : '' }}>
                                                        <a href="#!"
                                                            class="themes-color-change {{ $color == 'theme-7' ? 'active_color' : '' }}"
                                                            data-value="theme-7"></a>
                                                        <input type="radio" class="theme_color d-none" name="color"
                                                            value="theme-7"{{ $color == 'theme-7' ? 'checked' : '' }}>
                                                        <a href="#!"
                                                            class="themes-color-change {{ $color == 'theme-8' ? 'active_color' : '' }}"
                                                            data-value="theme-8"></a>
                                                        <input type="radio" class="theme_color d-none" name="color"
                                                            value="theme-8"{{ $color == 'theme-8' ? 'checked' : '' }}>
                                                        <a href="#!"
                                                            class="themes-color-change {{ $color == 'theme-9' ? 'active_color' : '' }}"
                                                            data-value="theme-9"></a>
                                                        <input type="radio" class="theme_color d-none" name="color"
                                                            value="theme-9"{{ $color == 'theme-9' ? 'checked' : '' }}>
                                                        <a href="#!"
                                                            class="themes-color-change {{ $color == 'theme-10' ? 'active_color' : '' }}"
                                                            data-value="theme-10"></a>
                                                        <input type="radio" class="theme_color d-none" name="color"
                                                            value="theme-10"{{ $color == 'theme-10' ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="color-picker-wrp">
                                                        <input type="color" value="{{ $color ? $color : '' }}"
                                                            class="colorPicker {{ isset($flag) && $flag == 'true' ? 'active_color' : '' }}"
                                                            name="custom_color" id="color-picker">
                                                        <input type='hidden' name="color_flag"
                                                            value={{ isset($flag) && $flag == 'true' ? 'true' : 'false' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xl-4 col-md-4">
                                                <h6 class="mt-2">
                                                    <i data-feather="layout"
                                                        class="me-2"></i>{{ __('Sidebar settings') }}
                                                </h6>
                                                <hr class="my-2" />
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input" id="cust-theme-bg"
                                                        name="cust_theme_bg"
                                                        {{ !empty($settings['cust_theme_bg']) && $settings['cust_theme_bg'] == 'on' ? 'checked' : '' }} />
                                                    <label class="form-check-label f-w-600 pl-1"
                                                        for="cust-theme-bg">{{ __('Transparent layout') }}</label>
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-4 col-xl-4 col-md-4">
                                            <h6 class="mt-2">
                                                <i data-feather="sun" class="me-2"></i>{{ __('Layout settings') }}
                                            </h6>
                                            <hr class="my-2" />
                                            <div class="form-check form-switch mt-2">
                                                <input type="checkbox" class="form-check-input" id="cust-darklayout"
                                                    name="cust_darklayout"{{ !empty($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on' ? 'checked' : '' }} />
                                                <label class="form-check-label f-w-600 pl-1"
                                                    for="cust-darklayout">{{ __('Dark Layout') }}</label>
                                            </div>
                                        </div> --}}
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <div class="form-group">
                                            <input class="btn btn-print-invoice btn-primary m-r-10" type="submit"
                                                value="{{ __('Save Changes') }}">
                                        </div>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Email Settings-->
            <div id="email-settings" class="card">
                <div class="card-header">
                    <h5>{{ __('Email Settings') }}</h5>
                    <small
                        class="text-muted">{{ __('This SMTP will be used for system-level email sending. Additionally, if a company user does not set their SMTP, then this SMTP will be used for sending emails.') }}</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('email.settings') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mail_driver" class="form-label">{{ __('Mail Driver') }}</label>
                                    <input type="text" name="mail_driver" id="mail_driver" class="form-control"
                                        placeholder="{{ __('Enter Mail Driver') }}"
                                        value="{{ old('mail_driver', $settings['mail_driver'] ?? '') }}">
                                    @error('mail_driver')
                                        <span class="invalid-feedback d-block">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mail_host" class="form-label">{{ __('Mail Host') }}</label>
                                    <input type="text" name="mail_host" id="mail_host" class="form-control"
                                        placeholder="{{ __('Enter Mail Host') }}"
                                        value="{{ old('mail_host', $settings['mail_host'] ?? '') }}">
                                    @error('mail_host')
                                        <span class="invalid-feedback d-block">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mail_port" class="form-label">{{ __('Mail Port') }}</label>
                                    <input type="number" name="mail_port" id="mail_port" class="form-control"
                                        placeholder="{{ __('Enter Mail Port') }}"
                                        value="{{ old('mail_port', $settings['mail_port'] ?? '') }}">
                                    @error('mail_port')
                                        <span class="invalid-feedback d-block">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mail_username" class="form-label">{{ __('Mail Username') }}</label>
                                    <input type="text" name="mail_username" id="mail_username" class="form-control"
                                        placeholder="{{ __('Enter Mail Username') }}"
                                        value="{{ old('mail_username', $settings['mail_username'] ?? '') }}">
                                    @error('mail_username')
                                        <span class="invalid-feedback d-block">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mail_password" class="form-label">{{ __('Mail Password') }}</label>
                                    <input type="text" name="mail_password" id="mail_password" class="form-control"
                                        placeholder="{{ __('Enter Mail Password') }}"
                                        value="{{ old('mail_password', $settings['mail_password'] ?? '') }}">
                                    @error('mail_password')
                                        <span class="invalid-feedback d-block">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mail_encryption" class="form-label">{{ __('Mail Encryption') }}</label>
                                    <input type="text" name="mail_encryption" id="mail_encryption"
                                        class="form-control" placeholder="{{ __('Enter Mail Encryption') }}"
                                        value="{{ old('mail_encryption', $settings['mail_encryption'] ?? '') }}">
                                    @error('mail_encryption')
                                        <span class="invalid-feedback d-block">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mail_from_address"
                                        class="form-label">{{ __('Mail From Address') }}</label>
                                    <input type="text" name="mail_from_address" id="mail_from_address"
                                        class="form-control" placeholder="{{ __('Enter Mail From Address') }}"
                                        value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}">
                                    @error('mail_from_address')
                                        <span class="invalid-feedback d-block">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mail_from_name" class="form-label">{{ __('Mail From Name') }}</label>
                                    <input type="text" name="mail_from_name" id="mail_from_name" class="form-control"
                                        placeholder="{{ __('Enter Mail From Name') }}"
                                        value="{{ old('mail_from_name', $settings['mail_from_name'] ?? '') }}">
                                    @error('mail_from_name')
                                        <span class="invalid-feedback d-block">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end">
                                <div class="me-2">
                                    <a href="#" class="btn btn-outline-primary send_email"
                                        data-url="{{ route('test.mail') }}" data-title="{{ __('Send Test Mail') }}">
                                        {{ __('Send Test Mail') }}
                                    </a>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save Changes') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="card" id="payment-settings">
                <div class="card-header">
                    <h5>{{ 'Payment Settings' }}</h5>
                    <small class="text-secondary font-weight-bold">
                        {{ __('These details will be used to collect subscription plan payments.Each subscription plan will have a payment button based on the below configuration.') }}
                    </small>
                </div>
                <form action="{{ route('payment.settings') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                  <form action="{{ route('payment.settings') }}" method="POST">
                                    @csrf
                                    <label for="currency">{{ __('Currency') }} <span class="text-danger">*</span></label>
                                    {{-- <div class="col-md-6 form-group">
                                        <label for="currencySearch">{{ __('Search Country') }}</label>
                                        <input type="text" id="currencySearch" class="form-control" placeholder="{{ __('Type country name...') }}">
                                    </div> --}}
                                   <select name="currency" id="currency" class="form-control" required onchange="updateCurrencySymbol()">
                                        {{-- <option value="">{{ __('Select Currency') }}</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency['code'] }}"
                                                {{ isset($admin_payment_setting['currency']) && $admin_payment_setting['currency'] == $currency['code'] ? 'selected' : '' }}>
                                                {{ $currency['name'] }} ({{ $currency['code'] }})
                                            </option>
                                        @endforeach --}}
                                   </select>

                                        <small class="text-xs">
                                            {{ __('Note: Currency is selected using ISO 4217 code.') }}
                                            <a href="https://stripe.com/docs/currencies" target="_blank">{{ __('Learn more.') }}</a>
                                        </small>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="currency_symbol">{{ __('Currency Symbol') }}</label>
                                        <input type="text" name="currency_symbol" id="currency_symbol"
                                            class="form-control" readonly required
                                            placeholder="{{ __('Auto-filled symbol') }}">
                                    </div>
                                </div>
                            </div>
                                <div class="faq justify-content-center">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="accordion accordion-flush setting-accordion"
                                                id="accordionExample">

                                                <!-- Manually -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseManually"
                                                            aria-expanded="false" aria-controls="collapseOne">
                                                            <span class="d-flex align-items-center">
                                                                {{ __('Manually') }}
                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2">{{ __('Enable') }}:</span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden"
                                                                        name="is_manually_payment_enabled" value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        id="customswitchv1-1 is_manually_payment_enabled"
                                                                        name="is_manually_payment_enabled"
                                                                        {{ isset($admin_payment_setting['is_manually_payment_enabled']) && $admin_payment_setting['is_manually_payment_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseManually" class="accordion-collapse collapse"
                                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row gy-4">
                                                                <div class="col-lg-12">
                                                                    <div class="input-edits">
                                                                        <small class="text-md">
                                                                            {{ __('Requesting manual payment for the planned amount for the subscriptions plan.') }}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Bank Transfer -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseBank"
                                                            aria-expanded="false" aria-controls="collapseOne">
                                                            <span class="d-flex align-items-center">
                                                                {{ __('Bank Transfer') }}
                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2">{{ __('Enable') }}:</span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_bank_transfer_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        id="customswitchv1-1 is_bank_transfer_enabled"
                                                                        name="is_bank_transfer_enabled"
                                                                        {{ isset($admin_payment_setting['is_bank_transfer_enabled']) && $admin_payment_setting['is_bank_transfer_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseBank" class="accordion-collapse collapse"
                                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row gy-4">
                                                                <div class="col-lg-12">
                                                                    <div class="input-edits">
                                                                        <div class="form-group">
                                                                            <label for="bank_details"
                                                                                class="col-form-label">{{ __('Bank Details') }}</label>
                                                                            <textarea id="bank_details" name="bank_details" class="form-control"
                                                                                placeholder="{{ __('Enter Your Bank Details') }}" rows="4">{{ isset($admin_payment_setting['bank_details']) ? $admin_payment_setting['bank_details'] : '' }}</textarea>

                                                                            <small class="text-xs">
                                                                                {{ __('Example : Bank : bank name </br> Account Number : 0000 0000 </br>') }}
                                                                            </small>
                                                                            @if ($errors->has('bank_details'))
                                                                                <span class="invalid-feedback d-block">
                                                                                    {{ $errors->first('bank_details') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Stripe -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="false" aria-controls="collapseOne">
                                                            <span class="d-flex align-items-center">
                                                                {{ __('Stripe') }}
                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2">{{ __('Enable') }}:</span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_stripe_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        id="customswitchv1-1 is_stripe_enabled"
                                                                        name="is_stripe_enabled"
                                                                        {{ isset($admin_payment_setting['is_stripe_enabled']) && $admin_payment_setting['is_stripe_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse"
                                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row gy-4">
                                                                <div class="col-lg-6">
                                                                    <div class="input-edits">
                                                                        <div class="form-group">
                                                                            <label for="stripe_key"
                                                                                class="col-form-label">{{ __('Stripe Key') }}</label>
                                                                            <input type="text" id="stripe_key"
                                                                                name="stripe_key" class="form-control"
                                                                                placeholder="{{ __('Enter Stripe Key') }}"
                                                                                value="{{ isset($admin_payment_setting['stripe_key']) ? $admin_payment_setting['stripe_key'] : '' }}">
                                                                            @if ($errors->has('stripe_key'))
                                                                                <span class="invalid-feedback d-block">
                                                                                    {{ $errors->first('stripe_key') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-edits">
                                                                        <div class="form-group">
                                                                            <label for="stripe_secret"
                                                                                class="col-form-label">{{ __('Stripe Secret') }}</label>
                                                                            <input type="text" id="stripe_secret"
                                                                                name="stripe_secret" class="form-control"
                                                                                placeholder="{{ __('Enter Stripe Secret') }}"
                                                                                value="{{ isset($admin_payment_setting['stripe_secret']) ? $admin_payment_setting['stripe_secret'] : '' }}">

                                                                            @if ($errors->has('stripe_secret'))
                                                                                <span class="invalid-feedback d-block">
                                                                                    {{ $errors->first('stripe_secret') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Paypal -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                            <span class="d-flex align-items-center">
                                                                {{ __('Paypal') }}
                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2">{{ __('Enable') }}:</span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_paypal_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        id="customswitchv1-1 is_paypal_enabled"
                                                                        name="is_paypal_enabled"
                                                                        {{ isset($admin_payment_setting['is_paypal_enabled']) && $admin_payment_setting['is_paypal_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="d-flex">
                                                                <div class="mr-2" style="margin-right: 15px;">
                                                                    <div class="border card p-1">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label text-dark">
                                                                                <input type="radio" name="paypal_mode"
                                                                                    value="sandbox"
                                                                                    class="form-check-input"
                                                                                    {{ (isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == '') || (isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == 'sandbox') ? 'checked="checked"' : '' }}>
                                                                                {{ __('Sandbox') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mr-2" style="margin-right: 15px;">
                                                                    <div class="border card p-1">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label text-dark">
                                                                                <input type="radio" name="paypal_mode"
                                                                                    value="live"
                                                                                    class="form-check-input"
                                                                                    {{ isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                                {{ __('Live') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row gy-4">
                                                                <div class="col-lg-6">
                                                                    <div class="input-edits">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label"
                                                                                for="paypal_client_id">{{ __('Client ID') }}</label>
                                                                            <input type="text" name="paypal_client_id"
                                                                                id="paypal_client_id" class="form-control"
                                                                                value="{{ !isset($admin_payment_setting['paypal_client_id']) || is_null($admin_payment_setting['paypal_client_id']) ? '' : $admin_payment_setting['paypal_client_id'] }}"
                                                                                placeholder="{{ __('Client ID') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-edits">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label"
                                                                                for="paypal_secret_key">{{ __('Secret Key') }}</label>
                                                                            <input type="text" name="paypal_secret_key"
                                                                                id="paypal_secret_key"
                                                                                class="form-control"
                                                                                value="{{ isset($admin_payment_setting['paypal_secret_key']) ? $admin_payment_setting['paypal_secret_key'] : '' }}"
                                                                                placeholder="{{ __('Secret Key') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Razorpay -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFive">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                            <span class="d-flex align-items-center">
                                                                {{ __('Razorpay') }}
                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2">{{ __('Enable') }}:</span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_razorpay_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        id="customswitchv1-1 is_razorpay_enabled"
                                                                        name="is_razorpay_enabled"
                                                                        {{ isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFive" class="accordion-collapse collapse"
                                                        aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row gy-4">
                                                                <div class="col-lg-6">
                                                                    <div class="input-edits">
                                                                        <div class="form-group">
                                                                            <label for="paypal_client_id"
                                                                                class="col-form-label">{{ __('Public Key') }}</label>
                                                                            <input type="text"
                                                                                name="razorpay_public_key"
                                                                                id="razorpay_public_key"
                                                                                class="form-control"
                                                                                value="{{ !isset($admin_payment_setting['razorpay_public_key']) || is_null($admin_payment_setting['razorpay_public_key']) ? '' : $admin_payment_setting['razorpay_public_key'] }}"
                                                                                placeholder="Public Key">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-edits">
                                                                        <div class="form-group">
                                                                            <label for="paystack_secret_key"
                                                                                class="col-form-label">
                                                                                {{ __('Secret Key') }}</label>
                                                                            <input type="text"
                                                                                name="razorpay_secret_key"
                                                                                id="razorpay_secret_key"
                                                                                class="form-control"
                                                                                value="{{ !isset($admin_payment_setting['razorpay_secret_key']) || is_null($admin_payment_setting['razorpay_secret_key']) ? '' : $admin_payment_setting['razorpay_secret_key'] }}"
                                                                                placeholder="Secret Key">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Paytm -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSix">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                                            aria-expanded="false" aria-controls="collapseSix">
                                                            <span class="d-flex align-items-center">
                                                                {{ __('Paytm') }}
                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2">{{ __('Enable') }}:</span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_paytm_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        id="customswitchv1-1 is_paytm_enabled"
                                                                        name="is_paytm_enabled"
                                                                        {{ isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSix" class="accordion-collapse collapse"
                                                        aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="col-md-12 pb-4">
                                                                <label class="paypal-label col-form-label"
                                                                    for="paypal_mode">{{ __('Paytm Environment') }}</label>
                                                                <br>
                                                                <div class="d-flex">
                                                                    <div class="mr-2" style="margin-right: 15px;">
                                                                        <div class="border card p-1">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label text-dark">
                                                                                    <input type="radio"
                                                                                        name="paytm_mode" value="local"
                                                                                        class="form-check-input"
                                                                                        {{ !isset($admin_payment_setting['paytm_mode']) || $admin_payment_setting['paytm_mode'] == '' || $admin_payment_setting['paytm_mode'] == 'local' ? 'checked="checked"' : '' }}>
                                                                                    {{ __('Local') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mr-2">
                                                                        <div class="border card p-1">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label text-dark">
                                                                                    <input type="radio"
                                                                                        name="paytm_mode"
                                                                                        value="production"
                                                                                        class="form-check-input"
                                                                                        {{ isset($admin_payment_setting['paytm_mode']) && $admin_payment_setting['paytm_mode'] == 'production' ? 'checked="checked"' : '' }}>
                                                                                    {{ __('Production') }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row gy-4">
                                                                <div class="col-lg-4">
                                                                    <div class="input-edits">
                                                                        <div class="form-group">
                                                                            <label for="paytm_public_key"
                                                                                class="col-form-label">{{ __('Merchant ID') }}</label>
                                                                            <input type="text" name="paytm_merchant_id"
                                                                                id="paytm_merchant_id"
                                                                                class="form-control"
                                                                                value="{{ isset($admin_payment_setting['paytm_merchant_id']) ? $admin_payment_setting['paytm_merchant_id'] : '' }}"
                                                                                placeholder="{{ __('Merchant ID') }}" />
                                                                            @if ($errors->has('paytm_merchant_id'))
                                                                                <span class="invalid-feedback d-block">
                                                                                    {{ $errors->first('paytm_merchant_id') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="input-edits">
                                                                        <div class="form-group">
                                                                            <label for="paytm_secret_key"
                                                                                class="col-form-label">{{ __('Merchant Key') }}</label>
                                                                            <input type="text"
                                                                                name="paytm_merchant_key"
                                                                                id="paytm_merchant_key"
                                                                                class="form-control"
                                                                                value="{{ isset($admin_payment_setting['paytm_merchant_key']) ? $admin_payment_setting['paytm_merchant_key'] : '' }}"
                                                                                placeholder="{{ __('Merchant Key') }}" />
                                                                            @if ($errors->has('paytm_merchant_key'))
                                                                                <span class="invalid-feedback d-block">
                                                                                    {{ $errors->first('paytm_merchant_key') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="input-edits">
                                                                        <div class="form-group">
                                                                            <label for="paytm_industry_type"
                                                                                class="col-form-label">{{ __('Industry Type') }}</label>
                                                                            <input type="text"
                                                                                name="paytm_industry_type"
                                                                                id="paytm_industry_type"
                                                                                class="form-control"
                                                                                value="{{ isset($admin_payment_setting['paytm_industry_type']) ? $admin_payment_setting['paytm_industry_type'] : '' }}"
                                                                                placeholder="{{ __('Industry Type') }}" />
                                                                            @if ($errors->has('paytm_industry_type'))
                                                                                <span class="invalid-feedback d-block">
                                                                                    {{ $errors->first('paytm_industry_type') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>




                                            <!-- Skrill -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingnine">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapsenine"
                                                        aria-expanded="false" aria-controls="collapsenine">
                                                        <span class="d-flex align-items-center">
                                                            {{ __('Skrill') }}
                                                        </span>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}:</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_skrill_enabled"
                                                                    value="off">
                                                                <input type="checkbox"
                                                                    class="form-check-input input-primary"
                                                                    id="customswitchv1-1 is_skrill_enabled"
                                                                    name="is_skrill_enabled"
                                                                    {{ isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapsenine" class="accordion-collapse collapse"
                                                    aria-labelledby="headingnine" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="row gy-4">
                                                            <div class="col-lg-6">
                                                                <div class="input-edits">
                                                                    <div class="form-group">
                                                                        <label for="mollie_api_key"
                                                                            class="col-form-label">{{ __('Skrill Email') }}</label>
                                                                        <input type="email" name="skrill_email"
                                                                            id="skrill_email" class="form-control"
                                                                            value="{{ isset($admin_payment_setting['skrill_email']) ? $admin_payment_setting['skrill_email'] : '' }}"
                                                                            placeholder="{{ __('Mollie Api Key') }}" />
                                                                        @if ($errors->has('skrill_email'))
                                                                            <span class="invalid-feedback d-block">
                                                                                {{ $errors->first('skrill_email') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- CoinGate -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingten">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseten"
                                                        aria-expanded="false" aria-controls="collapseten">
                                                        <span class="d-flex align-items-center">
                                                            {{ __('CoinGate') }}
                                                        </span>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ __('Enable') }}:</span>
                                                            <div class="form-check form-switch custom-switch-v1">
                                                                <input type="hidden" name="is_coingate_enabled"
                                                                    value="off">
                                                                <input type="checkbox"
                                                                    class="form-check-input input-primary"
                                                                    id="customswitchv1-1 is_coingate_enabled"
                                                                    name="is_coingate_enabled"
                                                                    {{ isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapseten" class="accordion-collapse collapse"
                                                    aria-labelledby="headingten" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-md-12 pb-4">
                                                            <label class="col-form-label"
                                                                for="coingate_mode">{{ __('CoinGate Mode') }}</label>
                                                            <br>
                                                            <div class="d-flex">
                                                                <div class="mr-2" style="margin-right: 15px;">
                                                                    <div class="border card p-1">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label text-dark">
                                                                                <input type="radio" name="coingate_mode"
                                                                                    value="sandbox"
                                                                                    class="form-check-input"
                                                                                    {{ !isset($admin_payment_setting['coingate_mode']) || $admin_payment_setting['coingate_mode'] == '' || $admin_payment_setting['coingate_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>
                                                                                {{ __('Sandbox') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mr-2" style="margin-right: 15px;">
                                                                    <div class="border card p-1">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label text-dark">
                                                                                <input type="radio" name="coingate_mode"
                                                                                    value="live"
                                                                                    class="form-check-input"
                                                                                    {{ isset($admin_payment_setting['coingate_mode']) && $admin_payment_setting['coingate_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                                {{ __('Live') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row gy-4">
                                                            <div class="col-lg-6">
                                                                <div class="input-edits">
                                                                    <div class="form-group">
                                                                        <label for="coingate_auth_token"
                                                                            class="col-form-label">{{ __('CoinGate Auth Token') }}</label>
                                                                        <input type="text" name="coingate_auth_token"
                                                                            id="coingate_auth_token" class="form-control"
                                                                            value="{{ !isset($admin_payment_setting['coingate_auth_token']) || is_null($admin_payment_setting['coingate_auth_token']) ? '' : $admin_payment_setting['coingate_auth_token'] }}"
                                                                            placeholder="CoinGate Auth Token">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn-submit btn btn-primary" type="submit">
                    {{ __('Save Changes') }}
                </button>
            </div>
            </form>
        </div>
    @endsection
<script>
    let currencyData = {};

    async function loadCurrencies() {
        try {
            const res = await fetch("https://restcountries.com/v3.1/all");
            const countries = await res.json();

            const seen = new Set();
            const currencySelect = document.getElementById('currency');

            countries.forEach(country => {
                if (country.currencies) {
                    Object.entries(country.currencies).forEach(([code, details]) => {
                        if (!seen.has(code)) {
                            seen.add(code);
                            const countryName = country.name.common || 'Unknown';

                            currencyData[code] = details.symbol || '';
                            const option = document.createElement("option");
                            option.value = code;
                            option.text = `${countryName} - ${code} - ${details.name}`;
                            currencySelect.appendChild(option);
                        }
                    });
                }
            });

            // Initialize Select2
            $('#currency').select2({
                placeholder: 'Select a currency',
                allowClear: true,
                width: '100%'
            });

            // If old value exists
            const oldCurrency = `{{ $admin_payment_setting['currency'] ?? '' }}`;
            if (oldCurrency) {
                $('#currency').val(oldCurrency).trigger('change');
                updateCurrencySymbol();
            }

        } catch (error) {
            console.error("Failed to load currencies:", error);
        }
    }

    function updateCurrencySymbol() {
        const currency = document.getElementById("currency").value;
        document.getElementById("currency_symbol").value = currencyData[currency] || '';
    }

    document.addEventListener("DOMContentLoaded", loadCurrencies);
</script>



