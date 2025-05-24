@extends('layouts.admin')
@section('page-title')
    {{__('Edit Employee')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('employee.index')}}">{{__('Employee')}}</a></li>
    <li class="breadcrumb-item">{{$employeesId}}</li>
@endsection


@section('content')
<div class="row">

    <form action="{{ route('employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 ">
                <div class="card emp_details">
                    <div class="card-header"><h6 class="mb-0">{{__('Personal Detail')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name" class="form-label">{{ __('Name') }}<x-required></x-required></label>
                                <input type="text" name="name" id="name" class="form-control" required placeholder="{{ __('Enter employee name') }}" value="{{ old('name', $employee->name ?? '') }}">

                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone" class="form-label">
                                {{ __('Phone') }} <x-required></x-required>
                            </label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ old('phone',$employee->phone) }}" required placeholder="Enter employee phone">

                            </div>
                            <div class="form-group col-md-6">

                                <label for="dob" class="form-label">{{ __('Date of Birth') }}<x-required></x-required></label>
                                <input type="date" name="dob" id="dob" class="form-control" required value="{{ old('dob', $employee->dob ?? '') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender" class="form-label">{{ __('Gender') }}<x-required></x-required></label>
                                <div class="d-flex radio-check mt-2">
                                    <div class="form-check form-check-inline form-group">
                                        <input type="radio" id="g_male" value="Male" name="gender" class="form-check-input" {{($employee->gender == 'Male')?'checked':''}} required>
                                        <label class="form-check-label" for="g_male">{{__('Male')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline form-group">
                                        <input type="radio" id="g_female" value="Female" name="gender" class="form-check-input" {{($employee->gender == 'Female')?'checked':''}} required>
                                        <label class="form-check-label" for="g_female">{{__('Female')}}</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="form-label">{{ __('Address') }}<x-required></x-required></label>
                            <textarea name="address" id="address" class="form-control" rows="2" required placeholder="{{ __('Enter employee address') }}">{{ old('address', $employee->address ?? '') }}</textarea>
                        </div>
                        @if(\Auth::user()->type == 'employee')
                        <button type="submit" class="btn-create btn-xs badge-blue radius-10px float-right">Update</button>
                        @endif
                    </div>
                </div>
            </div>
            @if(\Auth::user()->type != 'Employee')
                    <div class="col-md-6">
                    <div class="card emp_details">
                        <div class="card-header">
                            <h6 class="mb-0">{{ __('Company Detail') }}</h6>
                        </div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                @csrf
                                <div class="form-group col-md-12">
                                    <label for="employee_id" class="form-label">{{ __('Employee ID') }}</label>
                                    <input type="text" name="employee_id" id="employee_id" class="form-control" value="{{ $employeesId }}" disabled>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="branch_id" class="form-label">{{ __('Branch') }}</label><x-required></x-required>
                                    <select name="branch_id" id="branch_id" class="form-control select" required>
                                        @foreach($branches as $id => $name)
                                            <option value="{{ $id }}" {{ old('branch_id', $employee->branch_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="department_id" class="form-label">{{ __('Department') }}</label><x-required></x-required>
                                    <select name="department_id" id="department_id" class="form-control select" required>
                                        @foreach($departments as $id => $name)
                                            <option value="{{ $id }}" {{ old('department_id', $employee->department_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="designation_id" class="form-label">{{ __('Designation') }}</label><x-required></x-required>
                                    <select name="designation_id" id="designation_id" class="form-control select" required>
                                        @foreach($designations as $id => $name)
                                            <option value="{{ $id }}" {{ old('designation_id', $employee->designation_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="company_doj" class="form-label">Company Date Of Joining</label><x-required></x-required>
                                    <input type="date" name="company_doj" id="company_doj" class="form-control" required value="{{ old('company_doj', $employee->company_doj ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else

                <div class="col-md-6 ">
                    <div class="employee-detail-wrap ">
                        <div class="card emp_details">
                            <div class="card-header"><h6 class="mb-0">{{__('Company Detail')}}</h6></div>
                            <div class="card-body employee-detail-edit-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info">
                                            <strong>{{__('Branch')}}</strong>
                                            <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info font-style">
                                            <strong>{{__('Department')}}</strong>
                                            <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info font-style">
                                            <strong>{{__('Designation')}}</strong>
                                            <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info">
                                            <strong>{{__('Date Of Joining')}}</strong>
                                            <span>{{!empty($employee->company_doj)?$employee->company_doj:''}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if(\Auth::user()->type!='Employee')
        <div class="row d-flex align-items-stretch">
            <!-- Document Section -->
            <div class="col-md-6 d-flex">
                <div class="card emp_details w-100 h-100">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Document') }}</h6>
                    </div>
                    <div class="card-body employee-detail-edit-body d-flex flex-column">
                        @php
                            $employeedoc = $employee->documents()->pluck('document_value', __('document_id'));
                        @endphp

                            @foreach($documents as $key => $document)
                            @php
                                $logo = \App\Models\Utility::get_file('uploads/document/');
                                $existingDoc = $employeedoc[$document->id] ?? null;
                            @endphp

                            <div class="row mb-4">
                                <div class="form-group col-12">
                                    <div class="d-flex align-items-center  flex-wrap gap-1">
                                        <div class="d-flex align-items-center">
                                            <label class="form-label mb-0 me-3" for="document_input_{{ $document->id }}">
                                                {{ $document->name }}
                                                @if($document->is_required == 1)
                                                    <x-required></x-required>
                                                @endif
                                            </label>
                                        </div>

                                        <div class="choose-file">
                                            <label class="btn btn-sm btn-primary mb-0" for="document_input_{{ $document->id }}">
                                                Choose File
                                            </label>
                                            <input
                                                type="file"
                                                id="document_input_{{ $document->id }}"
                                                name="document[{{ $document->id }}]"
                                                class="d-none file-validate @error('document.'.$document->id) is-invalid @enderror"
                                                @if($document->is_required == 1 && empty($existingDoc)) required @endif
                                                onchange="document.getElementById('preview_{{ $document->id }}').src = window.URL.createObjectURL(this.files[0]); document.getElementById('preview_{{ $document->id }}').style.display = 'block';"
                                            >
                                        </div>
                                    </div>

                                    <!-- Image Preview -->
                                    <div class="mt-2">
                                        <img
                                            id="preview_{{ $document->id }}"
                                            src="{{ $existingDoc ? $logo.'/'.$existingDoc : '' }}"
                                            alt="Preview"
                                            class="img-thumbnail"
                                            style="max-width: 200px; {{ $existingDoc ? '' : 'display: none;' }}"
                                        >
                                    </div>

                                    @error('document.'.$document->id)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @endforeach


                    </div>
                </div>
            </div>

            <!-- Bank Account Section -->
            <div class="col-md-6 d-flex">
                <div class="card emp_details w-100 h-100">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Bank Account Detail') }}</h6>
                    </div>
                    <div class="card-body employee-detail-edit-body d-flex flex-column">
                        <div class="row">
                            @foreach ([
                                ['account_holder_name', 'Account Holder Name', 'text'],
                                ['account_number', 'Account Number', 'number'],
                                ['bank_name', 'Bank Name', 'text'],
                                ['bank_ifsc_code', 'Bank Ifsc Code', 'text'],
                                ['branch_location', 'Branch Location', 'text'],
                                ['tax_payer_id', 'Tax Payer Id', 'text'],
                            ] as [$id, $label, $type])
                                <div class="form-group col-md-6">
                                    <label for="{{ $id }}" class="form-label">{{ __($label) }}</label>
                                    <input type="{{ $type }}" name="{{ $id }}" id="{{ $id }}" class="form-control" placeholder="{{ __('Enter ' . strtolower($label)) }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
            <div class="row">
                <div class="col-md-6 ">
                    <div class="employee-detail-wrap">
                        <div class="card emp_details">
                            <div class="card-header"><h6 class="mb-0">{{__('Document Detail')}}</h6></div>
                            <div class="card-body employee-detail-edit-body">
                                <div class="row">
                                    @php
                                        $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                                    @endphp
                                    @foreach($documents as $key=>$document)
                                        <div class="col-md-12">
                                            <div class="info">
                                                <strong>{{$document->name }}</strong>
                                                <span><a href="{{ (!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="employee-detail-wrap">
                        <div class="card emp_details">
                            <div class="card-header"><h6 class="mb-0">{{__('Bank Account Detail')}}</h6></div>
                            <div class="card-body employee-detail-edit-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info">
                                            <strong>{{__('Account Holder Name')}}</strong>
                                            <span>{{$employee->account_holder_name}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info font-style">
                                            <strong>{{__('Account Number')}}</strong>
                                            <span>{{$employee->account_number}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info font-style">
                                            <strong>{{__('Bank Name')}}</strong>
                                            <span>{{$employee->bank_name}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info">
                                            <strong>{{__('Bank Ifsc Code')}}</strong>
                                            <span>{{$employee->bank_ifsc_code}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info">
                                            <strong>{{__('Branch Location')}}</strong>
                                            <span>{{$employee->branch_location}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info">
                                            <strong>{{__('Tax Payer Id')}}</strong>
                                            <span>{{$employee->tax_payer_id}}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(\Auth::user()->type != 'employee')
            <div class="row">
                <div class="col-12">
                    <input type="submit" value="{{__('Update')}}" class="btn btn-primary float-end">
                </div>
            </div>
        @endif
    </form>
</div>
@endsection

@push('script-page')
    <script>
        // Flatpickr Date Picker
        flatpickr("#dob, #company_doj", {
            dateFormat: "Y-m-d",
            maxDate: "today"
        });

        $(document).ready(function () {
            // Branch Change: Load Departments and Reset Designations
            $('#branch_id').on('change', function () {
                var branchId = $(this).val();
                if (branchId) {
                    loadDepartments(branchId);
                    $('#designation_id').empty().append(
                        '<option value="" disabled selected>Select Department First</option>'
                    );
                } else {
                    $('#department_id').empty().append('<option value="" disabled selected>Select Branch First</option>');
                    $('#designation_id').empty().append('<option value="" disabled selected>Select Department First</option>');
                }
            });

            // Department Change: Load Designations
            $('#department_id').on('change', function () {
                var departmentId = $(this).val();
                if (departmentId) {
                    loadDesignations(departmentId);
                } else {
                    $('#designation_id').empty().append('<option value="" disabled selected>Select Department First</option>');
                }
            });

            // Load Departments Function
            function loadDepartments(branchId) {
                $('#department_id').html('<option selected disabled>Loading departments...</option>');
                $.ajax({
                    url: '/get-departments',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        branch_id: branchId,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (data) {
                        $('#department_id').empty();
                        if ($.isEmptyObject(data)) {
                            $('#department_id').append('<option value="" disabled selected>No departments found</option>');
                            $('#designation_id').empty().append('<option value="" disabled selected>No designations available</option>');
                        } else {
                            $('#department_id').append('<option value="" disabled selected>Select Department</option>');
                            $.each(data, function (id, name) {
                                $('#department_id').append('<option value="' + id + '">' + name + '</option>');
                            });
                        }
                    },
                    error: function () {
                        $('#department_id').html('<option selected disabled>Error loading departments</option>');
                        $('#designation_id').empty().append('<option value="" disabled selected>Error loading designations</option>');
                    }
                });
            }

            // Load Designations Function
            function loadDesignations(departmentId) {
                $('#designation_id').html('<option selected disabled>Loading designations...</option>');
                $.ajax({
                    url: '/get-designations',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        department_id: departmentId,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (data) {
                        $('#designation_id').empty();
                        if ($.isEmptyObject(data)) {
                            $('#designation_id').append('<option value="" disabled selected>No designations found</option>');
                        } else {
                            $('#designation_id').append('<option value="" disabled selected>Select Designation</option>');
                            $.each(data, function (id, name) {
                                $('#designation_id').append('<option value="' + id + '">' + name + '</option>');
                            });
                        }
                    },
                    error: function () {
                        $('#designation_id').html('<option selected disabled>Error loading designations</option>');
                    }
                });
            }

            // Get Employee ID Based on Branch
            $('#branch_id').on('change', function () {
                var branchId = $(this).val();
                if (branchId) {
                    $.ajax({
                        url: '/get-employee-id/' + branchId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#employee_id').val(data.employee_id);
                        },
                        error: function () {
                            console.error('Error fetching employee ID');
                            $('#employee_id').val('');
                        }
                    });
                } else {
                    $('#employee_id').val('');
                }
            });
        });
    </script>
@endpush

