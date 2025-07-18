@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Role') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Role') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="lg" data-url="{{ route('roles.create') }}" data-ajax-popup="true"
            class="btn btn-sm btn-primary d-flex align-items-center gap-2">
            <i class="ti ti-plus"></i>
            <span>{{ __('Create New Role') }}</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Role') }} </th>
                                    <th>{{ __('Permissions') }} </th>
                                    <th width="150">{{ __('Action') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    @if ($role->name != 'client')
                                        <tr class="font-style">
                                            <td class="Role">{{ $role->name }}</td>
                                            <td class="Permission">
                                                <div style="max-height: 150px; overflow-y: auto;">
                                                    @foreach ($role->permissions()->pluck('name') as $permissionName)
                                                        <span
                                                            class="badge rounded p-2 m-1 px-3 bg-primary">{{ $permissionName }}</span>
                                                    @endforeach
                                                </div>
                                            </td>

                                            <td class="Action">
                                                <span>
                                                    @can('edit role')
                                                        <div class="action-btn me-2">
                                                            <a href="#" class="mx-3 btn btn-sm align-items-center bg-info"
                                                                data-url="{{ route('roles.edit', $role->id) }}"
                                                                data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                                title="{{ __('Edit') }}"
                                                                data-title="{{ __('Role Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @if ($role->name != 'Employee')
                                                        @can('delete role')
                                                            <div class="action-btn ">
                                                                <form method="POST"
                                                                    action="{{ route('roles.destroy', $role->id) }}"
                                                                    id="delete-form-{{ $role->id }}">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <a href="#"
                                                                        class="btn btn-sm align-items-center bs-pass-para bg-danger"
                                                                        data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                                        data-original-title="{{ __('Delete') }}"
                                                                        data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                                        data-confirm-yes="document.getElementById('delete-form-{{ $role->id }}').submit();">
                                                                        <i class="ti ti-trash text-white"></i>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        @endcan
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
