@extends('layouts.admin')
@php
    $profile = \App\Models\Utility::get_file('uploads/avatar');
    $user = auth()->user();
@endphp
@section('page-title')
    @if (\Auth::user()->type == 'super admin')
        {{ __('Manage Companies') }}
    @else
        {{ __('Manage User') }}
    @endif
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    @if ($user->type == 'super admin')
        <li class="breadcrumb-item">{{ __('Companies') }}</li>
    @else
        <li class="breadcrumb-item">{{ __('User') }}</li>
    @endif
@endsection
@section('action-btn')
    <div class="float-end">
        @if ($user->type == 'company' || $user->type == 'HR')
        <a href="{{ route('user.userlog') }}"
        class="btn btn-primary py-2 btn-sm me-1 {{ Request::is('user*') ? 'active' : '' }}">
         <i class="ti ti-user-check me-1"></i> {{ __('User Logs History') }}
     </a>

        @endif
        @can('create user')
            <a href="#" data-size="lg" data-url="{{ route('users.create') }}" data-ajax-popup="true"
                data-bs-toggle="tooltip" class="btn btn-sm btn-primary px-3 py-2 d-inline-flex align-items-center gap-2">

                @if (auth()->user()->type == 'super admin')
                    <i class="ti ti-building"></i>
                    {{ __('Create Company') }}
                @else
                    <i class="ti ti-user-plus"></i>
                    {{ __('Create User') }}
                @endif
            </a>
        @endcan
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="row">
                @foreach ($users as $user)
                    <div class="col-md-3 mb-4">
                        <div class="card text-center card-2">
                            <div class="card-header border-0 pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        @if (\Auth::user()->type == 'super admin')
                                            <div class="badge bg-primary p-2 px-3 rounded">
                                                {{ !empty($user->currentPlan) ? $user->currentPlan->name : '' }}
                                            </div>
                                        @else
                                            <div class="badge bg-primary p-2 px-3 rounded">
                                                {{ ucfirst($user->type) }}
                                            </div>
                                        @endif
                                    </h6>
                                </div>
                                @if (Gate::check('edit user') || Gate::check('delete user'))
                                    <div class="card-header-right">
                                        <div class="btn-group card-option">
                                            @if ($user->is_active == 1)
                                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>

                                                <div class="dropdown-menu dropdown-menu-end">

                                                    @can('edit user')
                                                    <a href="#" data-size="lg"
                                                        data-url="{{ route('users.edit', $user->id) }}"
                                                        data-ajax-popup="true" class="dropdown-item"
                                                        data-bs-original-title="{{ auth()->user()->type == 'super admin' ? __('Edit Company') : __('Edit User') }}">
                                                        <i class="ti ti-pencil"></i>
                                                        <span>{{ auth()->user()->type == 'super admin' ? __('Edit Company') : __('Edit User') }}</span>
                                                    </a>
                                                @endcan


                                                    @can('delete user')
                                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                                            id="delete-form-{{ $user->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="dropdown-item bs-pass-para">
                                                                <i class="ti ti-archive"></i>
                                                                <span>
                                                                    {{ $user->delete_status != 0 ? __('Delete') : __('Restore') }}
                                                                </span>
                                                            </button>
                                                        </form>
                                                    @endcan

                                                    @if (Auth::user()->type == 'super admin')
                                                        <a href="{{ route('login.with.company', $user->id) }}" class="dropdown-item"
                                                            data-bs-original-title="{{ __('Login As Company') }}">
                                                            <i class="ti ti-replace"></i>
                                                            <span> {{ __('Login As Company') }}</span>
                                                        </a>
                                                    @endif

                                                    <a href="#!" data-url="{{ route('users.reset',$user->id) }}" data-ajax-popup="true" data-size="md"
                                                        class="dropdown-item"
                                                        data-bs-original-title="{{ __('Reset Password') }}">
                                                        <i class="ti ti-adjustments"></i>
                                                        <span> {{ __('Reset Password') }}</span>
                                                    </a>

                                                    @if ($user->is_enable_login == 1)
                                                        <a href="{{route('users.login',$user->id)}}" class="dropdown-item">
                                                            <i class="ti ti-road-sign"></i>
                                                            <span class="text-danger"> {{ __('Login Disable') }}</span>
                                                        </a>
                                                    @elseif ($user->is_enable_login == 0 && $user->password == null)
                                                        <a href="#"
                                                            data-url="{{ route('users.reset', $user->id) }}"
                                                            data-ajax-popup="true" data-size="md"
                                                            class="dropdown-item login_enable"
                                                            data-title="{{ __('New Password') }}" class="dropdown-item">
                                                            <i class="ti ti-road-sign"></i>
                                                            <span class="text-success"> {{ __('Login Enable') }}</span>
                                                        </a>
                                                    @else
                                                        <a href="{{route('users.login',$user->id)}}" class="dropdown-item">
                                                            <i class="ti ti-road-sign"></i>
                                                            <span class="text-success"> {{ __('Login Enable') }}</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <a href="#" class="action-item text-lg"><i class="ti ti-lock"></i></a>
                                            @endif

                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body full-card">
                                <div class="img-fluid rounded-circle card-avatar">
                                    <img src="{{ !empty($user->avatar) ? \App\Models\Utility::get_file($user->avatar) : asset(Storage::url('avatars/__avatar.png')) }}"
                                        class="" width="120px" height="120px" alt="user-image">
                                </div>
                                <h4 class=" mt-3 text-primary">{{ $user->name }}</h4>
                                @if ($user->delete_status == 0)
                                    <h5 class="office-time mb-0">{{ __('Soft Deleted') }}</h5>
                                @endif
                                <small class="text-primary">{{ $user->email }}</small>
                                <p></p>
                                <div class="text-center text-muted small" data-bs-toggle="tooltip"
                                    title="{{ __('Last Login') }}">
                                    <i class="fas fa-clock me-2 text-primary"></i>
                                    {{ !empty($user->last_login_at) ? $user->last_login_at : __('Not Available') }}
                                </div>

                                @if (\Auth::user()->type == 'super admin')
                                    <div class="mt-1">
                                        <div class="row justify-content-center align-items-center">
                                            {{-- <div class="col-12 text-center mb-3">
                                            <a href="#"
                                               {{-- data-url="#" --}}
                                            {{-- data-size="lg"
                                               data-ajax-popup="true"
                                               class="btn btn-primary px-4  rounded-pill shadow-sm"
                                               data-title="{{ __('Upgrade Plan') }}">
                                                <i class="fas fa-arrow-up me-2"></i>{{ __('Upgrade Plan') }}
                                            </a> --}}
                                            {{-- </div> --}}

                                            <!-- Uncomment to show AdminHub button -->
                                            <!--
                                                <div class="col-12 text-center mb-3">
                                                    <a href="#"
                                                       data-url="#"
                                                       data-size="lg"
                                                       data-ajax-popup="true"
                                                       class="btn btn-outline-secondary px-4 py-2 rounded-pill"
                                                       data-title="{{ __('Company Info') }}">
                                                        {{-- {{ __('AdminHub') }} --}}
                                                    </a>
                                                </div>
                                                -->

                                            <div class="col-12">
                                                <hr class=" border-secondary">
                                            </div>

                                            <div class="col-12 text-center">
                                                <span class="text-muted fw-bold">
                                                    {{ __('Plan Expired :') }}
                                                    <span class="text-danger">
                                                        {{ !empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date) : __('Lifetime') }}
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-12">
                                            <div class="card mb-0">
                                                <div class="card-body p-3">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <p class="text-muted text-sm mb-0" data-bs-toggle="tooltip"
                                                                title="{{ __('Users') }}"><i
                                                                    class="ti ti-users card-icon-text-space"></i>{{ $user->totalCompanyUsers($user->id) }}
                                                            </p>
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="text-muted text-sm mb-0" data-bs-toggle="tooltip"
                                                                title="{{ __('Customers') }}"><i
                                                                    class="ti ti-users card-icon-text-space"></i>
                                                                {{-- {{ $user->totalCompanyCustomers($user->id) }} --}}
                                                            </p>
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="text-muted text-sm mb-0" data-bs-toggle="tooltip"
                                                                title="{{ __('Vendors') }}"><i
                                                                    class="ti ti-users card-icon-text-space"></i>
                                                                {{-- {{ $user->totalCompanyVenders($user->id) }} --}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        $(document).on('change', '#password_switch', function() {
            if ($(this).is(':checked')) {
                $('.ps_div').removeClass('d-none');
                $('#password').attr("required", true);

            } else {
                $('.ps_div').addClass('d-none');
                $('#password').val(null);
                $('#password').removeAttr("required");
            }
        });
        $(document).on('click', '.login_enable', function() {
            setTimeout(function() {
                $('.modal-body').append($('<input>', {
                    type: 'hidden',
                    val: 'true',
                    name: 'login_enable'
                }));
            }, 2000);
        });
    </script>
@endpush
