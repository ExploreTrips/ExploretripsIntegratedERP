@extends('layouts.admin')

@section('page-title')
    {{ __('Create Employee') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ url('employee') }}">{{ __('Employee') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create Employee') }}</li>
@endsection


@section('content')
    <div class="row">
        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation"
            novalidate>
            @csrf

            <div class="">
                <div class="">
                    <div class="row ">
                        <div class="col-md-6 mb-3">
                            <div class="card em-card h-100">
                                <div class="card-header">
                                    <h5>{{ __('Personal Detail') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="name" class="form-label">
                                                {{ __('Name') }}<x-required></x-required>
                                            </label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                                class="form-control" placeholder="{{ __('Enter employee name') }}"
                                                required>

                                        </div>
                                        {{-- <div class="form-group col-md-6">
                                            <x-mobile label="{{ __('Phone') }}" name="phone"
                                                value="{{ old('phone') }}" required
                                                placeholder="Enter employee phone"></x-mobile>
                                        </div> --}}

                                        <div class="form-group col-md-6">
                                            <label for="phone" class="form-label">
                                                {{ __('Phone') }} <x-required></x-required>
                                            </label>
                                            <input type="text" name="phone" id="phone" class="form-control"
                                                   value="{{ old('phone') }}" required placeholder="Enter employee phone">
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="dob" class="form-label">
                                                        {{ __('Date of Birth') }}<x-required></x-required>
                                                    </label>
                                                    <input type="date" id="dob" name="dob" class="form-control"
                                                        required autocomplete="off" placeholder="Select Date of Birth">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender" class="form-label" required>
                                                    {{ __('Gender') }}<x-required></x-required>
                                                </label>
                                                <div class="d-flex radio-check">
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="g_male" value="Male" name="gender"
                                                            class="form-check-input" checked>
                                                        <label class="form-check-label "
                                                            for="g_male">{{ __('Male') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio ms-1 custom-control-inline">
                                                        <input type="radio" id="g_female" value="Female" name="gender"
                                                            class="form-check-input">
                                                        <label class="form-check-label "
                                                            for="g_female">{{ __('Female') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email" class="form-label">{{ __('Email') }}</label>
                                            <x-required></x-required>
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control" placeholder="Enter employee email" required
                                                id="email" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <x-required></x-required>

                                            <input type="password" name="password" class="form-control"
                                                placeholder="Enter employee new password" required id="password" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <x-required></x-required>

                                        <textarea name="address" class="form-control" rows="2" placeholder="Enter employee address" required
                                            id="address">{{ old('address') }}</textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card em-card h-100">
                                <div class="card-header">
                                    <h5>{{ __('Company Detail') }}</h5>
                                </div>
                                <div class="card-body employee-detail-create-body">
                                    <div class="row">
                                        @csrf
                                        <div class="form-group ">
                                            <label for="employee_id" class="form-label">{{ __('Employee ID') }}</label>
                                            <input type="text" name="employee_id" value="{{ $employeesId }}"
                                                class="form-control" disabled id="employee_id">

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="branch_id" class="form-label">{{ __('Select Branch') }}</label>
                                            <x-required></x-required>
                                            <div class="form-icon-user">
                                                <select name="branch_id" id="branch_id" class="form-control" required>
                                                    <option value="" disabled selected>{{ __('Select Branch') }}
                                                    </option>
                                                    @foreach ($branches as $key => $branch)
                                                        <option value="{{ $key }}">{{ $branch }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="department_id"
                                                class="form-label">{{ __('Select Department') }}</label>
                                            <x-required></x-required>
                                            <div class="form-icon-user">
                                                <select name="department_id" id="department_id" class="form-control"
                                                    required>
                                                    <option value="" disabled selected>{{ __('Select Department') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="designation_id"
                                                class="form-label">{{ __('Select Designation') }}</label>
                                            <x-required></x-required>
                                            <div class="form-icon-user">
                                                <select name="designation_id" id="designation_id" class="form-control"
                                                    required>
                                                    <option value="" disabled selected>
                                                        {{ __('Select Designation') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="company_doj"
                                                class="form-label">{{ __('Company Date Of Joining') }}</label>
                                            <x-required></x-required>
                                            <input type="date" name="company_doj" id="company_doj"
                                                class="form-control" required autocomplete="off"
                                                placeholder="{{ __('Select company date of joining') }}">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 ">
                            <div class="card em-card">
                                <div class="card-header">
                                    <h5>{{ __('Document') }}</h6>
                                </div>
                                <div class="card-body employee-detail-create-body">
                                    @foreach ($documents as $key => $document)
                                        <div class="row">
                                            <div class="form-group col-12 d-flex">
                                                <div class="float-left col-4">
                                                    <label for="document"
                                                        class="float-left pt-1 form-label">{{ $document->name }}
                                                        @if ($document->is_required == 1)
                                                            <x-required></x-required>
                                                        @endif
                                                    </label>
                                                </div>
                                                <div class="float-right col-8">
                                                    <input type="hidden" name="emp_doc_id[{{ $document->id }}]"
                                                        id="" value="{{ $document->id }}">
                                                    <div class="choose-files">
                                                        <label for="document[{{ $document->id }}]">
                                                            <div class=" bg-primary document "> <i
                                                                    class="ti ti-upload "></i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file"
                                                                class="form-control file file-validate d-none @error('document') is-invalid @enderror"
                                                                @if ($document->is_required == 1) required @endif
                                                                name="document[{{ $document->id }}]"
                                                                id="document[{{ $document->id }}]"
                                                                data-filename="{{ $document->id . '_filename' }}"
                                                                onchange="document.getElementById('{{ 'blah' . $key }}').src = window.URL.createObjectURL(this.files[0])">
                                                            <p id="" class="file-error text-danger"></p>
                                                        </label>
                                                        <img id="{{ 'blah' . $key }}" src="" width="50%" />

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="card em-card">
                                <div class="card-header">
                                    <h5>{{ __('Bank Account Detail') }}</h5>
                                </div>
                                <div class="card-body employee-detail-create-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="account_holder_name"
                                                class="form-label">{{ __('Account Holder Name') }}</label>
                                            <input type="text" name="account_holder_name" id="account_holder_name"
                                                class="form-control" value="{{ old('account_holder_name') }}"
                                                placeholder="{{ __('Enter account holder name') }}">

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="account_number"
                                                class="form-label">{{ __('Account Number') }}</label>
                                            <input type="number" name="account_number" id="account_number"
                                                class="form-control" value="{{ old('account_number') }}"
                                                placeholder="{{ __('Enter account number') }}">

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="bank_name" class="form-label">{{ __('Bank Name') }}</label>
                                            <input type="text" name="bank_name" id="bank_name" class="form-control"
                                                value="{{ old('bank_name') }}"
                                                placeholder="{{ __('Enter bank name') }}">

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="bank_ifsc_code"
                                                class="form-label">{{ __('Bank Identifier Code') }}</label>
                                            <input type="text" name="bank_ifsc_code" id="bank_ifsc_code"
                                                class="form-control" value="{{ old('bank_ifsc_code') }}"
                                                placeholder="{{ __('Enter bank ifsc code') }}">``
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="branch_location"
                                                class="form-label">{{ __('Branch Location') }}</label>
                                            <input type="text" name="branch_location" id="branch_location"
                                                class="form-control" value="{{ old('branch_location') }}"
                                                placeholder="{{ __('Enter branch location') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="tax_payer_id" class="form-label">{{ __('Tax Payer Id') }}</label>
                                            <input type="text" name="tax_payer_id" id="tax_payer_id"
                                                class="form-control" value="{{ old('tax_payer_id') }}"
                                                placeholder="{{ __('Enter tax payer id') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="float-end">
                    <button type="submit" class="btn  btn-primary">{{ 'Create' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script-page')
    <script>
        function previewImage(event, previewId) {
            var output = document.getElementById(previewId);
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        }
    </script>
    <script>
        flatpickr("#dob, #company_doj", {
            dateFormat: "Y-m-d",
            maxDate: "today"
        });
    </script>

    <script>
        $('input[type="file"]').change(function(e) {
            var file = e.target.files[0].name;
            var file_name = $(this).attr('data-filename');
            $('.' + file_name).append(file);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#branch_id').on('change', function() {
                var branchId = $(this).val();
                if (branchId) {
                    loadDepartments(branchId);
                }
            });

            function loadDepartments(branchId) {
                $('#department_id').html('<option selected disabled>Loading...</option>');

                $.ajax({
                    url: '/get-departments',
                    type: 'POST', // use POST now because we are sending _token
                    dataType: 'json',
                    data: {
                        "branch_id": branchId,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('#department_id').empty();
                        if ($.isEmptyObject(data)) {
                            $('#department_id').append(
                                '<option value="" disabled selected>No departments found</option>');
                        } else {
                            $('#department_id').append(
                                '<option value="" disabled selected>Select Department</option>');
                            $.each(data, function(id, name) {
                                $('#department_id').append('<option value="' + id + '">' +
                                    name + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#department_id').html(
                            '<option selected disabled>Error loading departments</option>');
                        console.error('Error fetching departments:', error);
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#department_id').on('change', function() {
                var departmentId = $(this).val();
                if (departmentId) {
                    loadDesignations(departmentId);
                }
            });

            function loadDesignations(departmentId) {
                $('#designation_id').html('<option selected disabled>Loading...</option>');

                $.ajax({
                    url: '/get-designations', // Adjust your URL here for the route
                    type: 'POST', // Use POST because we are sending the CSRF token
                    dataType: 'json',
                    data: {
                        "department_id": departmentId,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('#designation_id').empty();
                        if ($.isEmptyObject(data)) {
                            $('#designation_id').append(
                                '<option value="" disabled selected>No designations found</option>');
                        } else {
                            $('#designation_id').append(
                                '<option value="" disabled selected>Select Designation</option>');
                            $.each(data, function(id, name) {
                                $('#designation_id').append('<option value="' + id + '">' +
                                    name + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#designation_id').html(
                            '<option selected disabled>Error loading designations</option>');
                        console.error('Error fetching designations:', error);
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function(){
                $('#branch_id').on('change',function(){
                    var branchId = $(this).val();
                    if(branchId){
                        $.ajax({
                            url: '/get-employee-id/' + branchId,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#employee_id').val(data.employee_id);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching employee ID:', error);
                            }
                        });
                    } else {
                        $('#employee_id').val('');
                    }
                });
        })

        // document.getElementById('branch_id').addEventListener('change', function () {
        //     const branchId = this.value;
        //     fetch(`/get-employee-id/${branchId}`)
        //         .then(response => response.json())
        //         .then(data => {
        //             document.getElementById('employee_id').value = data.employee_id;
        //         });
        // });
    </script>

@endpush
