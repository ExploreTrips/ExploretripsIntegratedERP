@extends('layouts.admin')

@section('page-title')
    {{__('Employee')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('employee.index')}}">{{__('Employee')}}</a></li>
    <li class="breadcrumb-item">{{$employee->employee_id}}</li>
@endsection

@section('action-btn')
    @if(!empty($employee))
        <div class="float-end mt-3 m-2">
            @can('edit employee')

                <a href="{{route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" data-bs-toggle="tooltip" title="{{__('Edit')}}"class="btn btn-sm btn-primary">
                    <i class="ti ti-pencil"></i>
                </a>

            @endcan
        </div>

        <div class="text-end">
            <div class="d-flex justify-content-end drp-languages">
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item status-drp">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="drp-text hide-mob text-primary"> {{__('Joining Letter')}}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown">
                            <a href="" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>

                            <a href="" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item status-drp">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="drp-text hide-mob text-primary"> {{__('Experience Certificate')}}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown">
                            <a href="" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>

                            <a href="" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item status-drp">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="drp-text hide-mob text-primary"> {{__('NOC')}}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown">
                            <a href="" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>

                            <a href="" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    @endif
@endsection

@section('content')
    @if(!empty($employee))
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    {{-- Personal Detail Card --}}
                    <div class="col-sm-12 col-md-6 d-flex justify-content-center">
                        <div class="card employee-card shadow-lg p-3 mb-4">
                            <div class="card-body employee-detail-body">
                                <h4 class="card-title text-custom mb-3 text-center">
                                    <i class="fas fa-user-circle me-2"></i> {{ __('Personal Detail') }}
                                </h4>
                                <hr>
                                <div class="row gy-3">
                                    @php
                                        $details = [
                                            ['icon' => 'id-badge', 'label' => 'EmployeeId', 'value' => $employee->employee_id],
                                            ['icon' => 'user', 'label' => 'Name', 'value' => $employee->name ?? ''],
                                            ['icon' => 'envelope', 'label' => 'Email', 'value' => $employee->email ?? ''],
                                            ['icon' => 'birthday-cake', 'label' => 'Date of Birth', 'value' => \App\Helpers\CustomHelper::dateFormat($employee->dob ?? '')],
                                            ['icon' => 'phone', 'label' => 'Phone', 'value' => $employee->phone ?? ''],
                                            ['icon' => 'map-marker-alt', 'label' => 'Address', 'value' => $employee->address ?? ''],
                                            ['icon' => 'wallet', 'label' => 'Salary Type', 'value' => $employee->salaryType->name ?? ''],
                                            ['icon' => 'money-bill-wave', 'label' => 'Basic Salary', 'value' => $employee->salary ?? '']
                                        ];
                                    @endphp

                                    @foreach($details as $detail)
                                        <div class="col-md-6">
                                            <div class="info text-sm d-flex align-items-center">
                                                <i class="fas fa-{{ $detail['icon'] }} me-2 text-custom"></i>
                                                <strong class="font-bold me-1">{{ __($detail['label']) }}:</strong>
                                                <span class="text-custom fw-semibold">{{ $detail['value'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Company Detail Card --}}
                    <div class="col-sm-12 col-md-6 d-flex justify-content-center">
                        <div class="card employee-card shadow-lg p-3 mb-4">
                            <div class="card-body employee-detail-body">
                                <h4 class="card-title text-custom mb-3 text-center">
                                    <i class="fas fa-building me-2"></i> {{ __('Company Detail') }}
                                </h4>
                                <hr>
                                <div class="row gy-3">
                                    @php
                                        $companyDetails = [
                                            ['icon' => 'code-branch', 'label' => 'Branch', 'value' => $employee->branch->name ?? ''],
                                            ['icon' => 'users-cog', 'label' => 'Department', 'value' => $employee->department->name ?? ''],
                                            ['icon' => 'user-tie', 'label' => 'Designation', 'value' => $employee->designation->name ?? ''],
                                            ['icon' => 'calendar-alt', 'label' => 'Date Of Joining', 'value' => \App\Helpers\CustomHelper::dateFormat($employee->doj ?? '')],
                                        ];
                                    @endphp

                                    @foreach($companyDetails as $detail)
                                        <div class="col-md-6">
                                            <div class="info text-sm d-flex align-items-center">
                                                <i class="fas fa-{{ $detail['icon'] }} me-2 text-custom"></i>
                                                <strong class="font-bold me-1">{{ __($detail['label']) }}:</strong>
                                                <span class="text-custom fw-semibold">{{ $detail['value'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12 col-md-6 d-flex">
                        <div class="card employee-card shadow-lg p-3 mb-4 w-100">
                            <div class="card-body employee-detail-body">
                                <h4 class="card-title text-custom mb-3 text-center">
                                    <i class="fas fa-file-alt me-2"></i> {{ __('Document Detail') }}
                                </h4>
                                <hr>
                                <div class="row gy-3">
                                    @php
                                        $employeedoc = !empty($employee) ? $employee->documents()->pluck('document_value', 'document_id') : [];
                                    @endphp

                                    @if(!$documents->isEmpty())
                                        @foreach($documents as $key => $document)
                                            <div class="col-md-6">
                                                <div class="info text-sm d-flex align-items-center">
                                                    <i class="fas fa-file me-2 text-custom"></i>
                                                    <strong class="font-bold me-1">{{ $document->name }}:</strong>
                                                    <span class="text-custom fw-semibold">
                                                        @if(!empty($employeedoc[$document->id]))
                                                            <a href="{{ asset(Storage::url('uploads/document/' . $employeedoc[$document->id])) }}" target="_blank">
                                                                {{ $employeedoc[$document->id] }}
                                                            </a>
                                                        @else
                                                            {{ __('N/A') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center">
                                            <em>{{ __('No Document Type Added.') }}</em>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 d-flex">
                        <div class="card employee-card shadow-lg p-3 mb-4 w-100">
                            <div class="card-body employee-detail-body">
                                <h4 class="card-title text-custom mb-3 text-center">
                                    <i class="fas fa-university me-2"></i> {{ __('Bank Account Detail') }}
                                </h4>
                                <hr>
                                <div class="row gy-3">
                                    @php
                                        $bankDetails = [
                                            ['icon' => 'user', 'label' => 'Account Holder Name', 'value' => $employee->account_holder_name ?? ''],
                                            ['icon' => 'credit-card', 'label' => 'Account Number', 'value' => $employee->account_number ?? ''],
                                            ['icon' => 'building', 'label' => 'Bank Name', 'value' => $employee->bank_name ?? ''],
                                            ['icon' => 'barcode', 'label' => 'Bank Identifier Code', 'value' => $employee->bank_identifier_code ?? ''],
                                            ['icon' => 'map-marker-alt', 'label' => 'Branch Location', 'value' => $employee->branch_location ?? ''],
                                            ['icon' => 'file-invoice-dollar', 'label' => 'Tax Payer Id', 'value' => $employee->tax_payer_id ?? ''],
                                        ];
                                    @endphp

                                    @foreach($bankDetails as $detail)
                                        <div class="col-md-6">
                                            <div class="info text-sm d-flex align-items-center">
                                                <i class="fas fa-{{ $detail['icon'] }} me-2 text-custom"></i>
                                                <strong class="font-bold me-1">{{ __($detail['label']) }}:</strong>
                                                <span class="text-custom fw-semibold">{{ $detail['value'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection
