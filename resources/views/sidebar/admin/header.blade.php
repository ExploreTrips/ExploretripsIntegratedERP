@php
    $users = \Auth::user();
    $avatars = \App\Models\Utility::get_file('avatars/');
    $languages = \App\Models\Utility::languages();
    $lang = isset($users->lang) ? $users->lang : 'en';
    if ($lang == null) {
        $lang = 'en';
    }
    // $LangName = \App\Models\Language::where('code',$lang)->first();
    // $LangName =\App\Models\Language::languageData($lang);
    $LangName = cache()->remember('full_language_data_' . $lang, now()->addHours(24), function () use ($lang) {
        return \App\Models\Language::languageData($lang);
    });
    $setting = \App\Models\Utility::settings();
@endphp
@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on')
    <header class="dash-header transprent-bg">
    @else
        <header class="dash-header">
@endif
<div class="header-wrapper">
    <div class="me-auto dash-mob-drp">
        <ul class="list-unstyled">
            <li class="dash-h-item mob-hamburger">
                <a href="#!" class="dash-head-link" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box">
                            <div class="hamburger-inner"></div>
                        </div>
                    </div>
                </a>
            </li>

            <li class="dropdown dash-h-item drp-company">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="theme-avatar"
                        style="display: inline-block; width: 40px; height: 40px; overflow: hidden;">
                        <img src="{{ !empty(Auth::user()->avatar) ? $avatars . Auth::user()->avatar : $avatars . 'avatar.png' }}"
                            alt="User Avatar" class="img-fluid rounded-circle"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </span>
                    <span class="hide-mob ms-2">{{ \Auth::user()->name }}!</span>
                    <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                </a>
                <div class="dropdown-menu dash-h-dropdown">
                    <a href="{{ route('profile') }}" class="dropdown-item">
                        <i class="ti ti-user text-dark"></i><span>{{ __('Profile') }}</span>
                    </a>

                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                        class="dropdown-item">
                        <i class="ti ti-power text-dark"></i><span>{{ __('Logout') }}</span>
                    </a>

                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>

                </div>
            </li>

        </ul>
    </div>
    <div class="ms-auto">
        <ul class="list-unstyled">
            @if (auth()->user()->type == 'company')
                @impersonating($guard = null)
                    <li class="dropdown dash-h-item drp-company">
                        <a class="btn btn-danger btn-sm me-3" href="{{ route('exit.company') }}"><i class="ti ti-ban"></i>
                            {{ __('Exit Company Login') }}
                        </a>
                    </li>
                @endImpersonating
            @endif

            @if (\Auth::user()->type != 'client' && \Auth::user()->type != 'super admin')
                <li class="dropdown dash-h-item drp-notification">
                    <a class="dash-head-link arrow-none me-0" href="{{ url('chats') }}" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-brand-hipchat"></i>
                        <span
                            class="bg-danger dash-h-badge message-toggle-msg  message-counter custom_messanger_counter beep">0<span
                                class="sr-only"></span>
                        </span>
                    </a>
                </li>
            @endif

            <li class="dropdown dash-h-item drp-language">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-world nocolor"></i>
                    <span class="drp-text hide-mob">{{ ucfirst($LangName->full_name) }}</span>
                    <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                </a>
                <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                    @foreach ($languages as $code => $language)
                        <a href="{{ route('change.language', $code) }}"
                            class="dropdown-item {{ $lang == $code ? 'text-primary' : '' }}">
                            <span>{{ ucFirst($language) }}</span>
                        </a>
                    @endforeach

                    <h></h>
                    @if (\Auth::user()->type == 'super admin')
                        <a data-url="#" class="dropdown-item text-primary" data-ajax-popup="true"
                            data-title="{{ __('Create New Language') }}">
                            {{ __('Create Language') }}
                        </a>
                        <a class="dropdown-item text-primary" href="#   ">{{ __('Manage Language') }}</a>
                    @endif
                </div>
            </li>
        </ul>
    </div>
</div>
</header>
