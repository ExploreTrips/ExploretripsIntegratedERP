{{-- {{Form::open(array('url'=>'roles','method'=>'post', 'class'=>'needs-validation', 'novalidate'))}} --}}
@php
    $permissionTypes = [
        'view' => 'View',
        'add' => 'Add',
        'move' => 'Move',
        'manage' => 'Manage',
        'create' => 'Create',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'show' => 'Show',
        'send' => 'Send',
        'create payment' => 'Create Payment',
        'delete payment' => 'Delete Payment',
        'income' => 'Income',
        'expense' => 'Expense',
        'income vs expense' => 'Income VS Expense',
        'loss & profit' => 'Loss & Profit',
        'tax' => 'Tax',
        'invoice' => 'Invoice',
    ];
@endphp
<form action="{{ route('roles.store') }}" method="POST" class="needs-validation" novalidate>
    @csrf
    {{-- @method('POST') --}}
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="name" class="form-label">
                        {{ __('Name') }} <x-required></x-required>
                    </label>
                    <input type="text" name="name" id="name" class="form-control"
                        placeholder="{{ __('Enter Role Name') }}" required>

                    @error('name')
                        <small class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="flex-wrap: wrap;">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-staff-tab" data-bs-toggle="pill" href="#staff"
                            role="tab" aria-controls="pills-staff" aria-selected="true"
                            style="border: 1px solid #dee2e6; margin-right: 8px; border-radius: 5px;"">{{ __('Staff') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-crm-tab" data-bs-toggle="pill" href="#crm" role="tab"
                            aria-controls="pills-crm" aria-selected="false"
                            style="border: 1px solid #dee2e6; margin-right: 8px; border-radius: 5px;">
                            {{ __('CRM') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-project-tab" data-bs-toggle="pill" href="#project" role="tab"
                            aria-controls="pills-project" aria-selected="false"
                            style="border: 1px solid #dee2e6; margin-right: 8px; border-radius: 5px;">
                            {{ __('Project') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-hrmpermission-tab" data-bs-toggle="pill" href="#hrmpermission"
                            role="tab" aria-controls="pills-hrmpermission" aria-selected="false"
                            style="border: 1px solid #dee2e6; margin-right: 8px; border-radius: 5px;"">
                            {{ __('HRM') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-account-tab" data-bs-toggle="pill" href="#account" role="tab"
                            aria-controls="pills-account" aria-selected="false"
                            style="border: 1px solid #dee2e6; margin-right: 8px; border-radius: 5px;">
                            {{ __('Account') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-pos-tab" data-bs-toggle="pill" href="#pos" role="tab"
                            aria-controls="pills-pos" aria-selected="false"
                            style="border: 1px solid #dee2e6; margin-right: 8px; border-radius: 5px;">
                            {{ __('POS') }}
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="staff" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        @php
                            $modules = [
                                'user',
                                'role',
                                'client',
                                'product & service',
                                'constant unit',
                                'constant tax',
                                'constant category',
                                'zoom meeting',
                                'company settings',
                            ];
                            if (\Auth::user()->type == 'company') {
                                $modules[] = 'permission';
                            }
                        @endphp
                        <div class="col-md-12">
                            <div class="form-group">
                                @if (!empty($permissions))
                                    <h6 class="my-3">{{ __('Assign General Permission to Roles') }}</h6>
                                    <table class="table table-striped mb-0" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-check d-flex align-items-center gap-2">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="staff_checkall" id="staff_checkall">
                                                        <label for="staff_checkall" class="form-check-label mb-0">
                                                            {{ __('Select All') }}
                                                        </label>
                                                    </div>
                                                </th>

                                                <th>{{ __('Module') }} </th>
                                                <th>{{ __('Permissions') }} </th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            @foreach ($modules as $module)
                                                @php
                                                    $cleanModule = str_replace([' ', '&'], '', $module);
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input ischeck staff_checkall"
                                                            data-id="{{ $cleanModule }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck staff_checkall"
                                                            data-id="{{ $cleanModule }}">
                                                            {{ ucfirst($module) }}
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($permissionTypes as $prefix => $label)
                                                                @php
                                                                    $permissionName = $prefix . ' ' . $module;
                                                                    $key = array_search(
                                                                        $permissionName,
                                                                        (array) $permissions,
                                                                    );
                                                                @endphp

                                                                @if ($key !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            class="form-check-input isscheck staff_checkall isscheck_{{ $cleanModule }}"
                                                                            id="permission{{ $key }}">
                                                                        <label for="permission{{ $key }}"
                                                                            class="custom-control-label">
                                                                            {{ $label }}
                                                                        </label><br>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="crm" role="tabpanel" aria-labelledby="pills-profile-tab">
                        @php
                            $modules = [
                                'crm dashboard',
                                'lead',
                                'pipeline',
                                'lead stage',
                                'source',
                                'label',
                                'deal',
                                'stage',
                                'task',
                                'form builder',
                                'form response',
                                'contract',
                                'contract type',
                            ];
                        @endphp
                        <div class="col-md-12">
                            <div class="form-group">
                                @if (!empty($permissions))
                                    <h6 class="my-3">{{ __('Assign CRM related Permission to Roles') }}</h6>
                                    <table class="table table-striped mb-0" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-check d-flex align-items-center gap-2">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="staff_checkall" id="staff_checkall">
                                                        <label for="staff_checkall" class="form-check-label mb-0">
                                                            {{ __('Select All') }}
                                                        </label>
                                                    </div>
                                                </th>
                                                <th>{{ __('Module') }} </th>
                                                <th>{{ __('Permissions') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($modules as $module)
                                                @php $moduleKey = str_replace(' ', '', $module); @endphp
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input ischeck crm_checkall"
                                                            data-id="{{ $moduleKey }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck crm_checkall"
                                                            data-id="{{ $moduleKey }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($permissionTypes as $action => $label)
                                                                @php
                                                                    $permissionString = $action . ' ' . $module;
                                                                    $key = array_search(
                                                                        $permissionString,
                                                                        $permissions,
                                                                    );
                                                                @endphp
                                                                @if ($key !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            id="permission{{ $key }}"
                                                                            class="form-check-input isscheck crm_checkall isscheck_{{ $moduleKey }}">
                                                                        <label for="permission{{ $key }}"
                                                                            class="custom-control-label">{{ $label }}</label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="project" role="tabpanel" aria-labelledby="pills-contact-tab">
                        @php
                            $modules = [
                                'project dashboard',
                                'project',
                                'milestone',
                                'grant chart',
                                'project stage',
                                'timesheet',
                                'project expense',
                                'project task',
                                'activity',
                                'CRM activity',
                                'project task stage',
                                'bug report',
                                'bug status',
                            ];
                        @endphp
                        <div class="col-md-12">
                            <div class="form-group">
                                @if (!empty($permissions))
                                    <h6 class="my-3">{{ __('Assign Project related Permission to Roles') }}</h6>
                                    <table class="table table-striped mb-0" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-check d-flex align-items-center gap-2">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="project_checkall" id="project_checkall">
                                                        <label for="project_checkall" class="form-check-label mb-0">
                                                            {{ __('Select All') }}
                                                        </label>
                                                    </div>
                                                </th>
                                                <th>{{ __('Module') }} </th>
                                                <th>{{ __('Permissions') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($modules as $module)
                                                @php $moduleKey = str_replace(' ', '', $module); @endphp

                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input align-middle ischeck project_checkall"
                                                            data-id="{{$moduleKey}}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck project_checkall"
                                                            data-id="{{ $moduleKey }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($permissionTypes as $prefix => $label)
                                                                @php
                                                                    $key = array_search(
                                                                        $prefix . ' ' . $module,
                                                                        $permissions,
                                                                    );
                                                                @endphp
                                                                @if ($key !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            id="permission{{ $key }}"
                                                                            class="form-check-input isscheck project_checkall isscheck_{{ $moduleKey }}">
                                                                        <label for="permission{{ $key }}"
                                                                            class="custom-control-label">{{ $label }}</label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="hrmpermission" role="tabpanel"
                        aria-labelledby="pills-contact-tab">
                        @php
                            $modules = [
                                'hrm dashboard',
                                'employee',
                                'employee profile',
                                'department',
                                'designation',
                                'branch',
                                'document type',
                                'document',
                                'payslip type',
                                'allowance',
                                'commission',
                                'allowance option',
                                'loan option',
                                'deduction option',
                                'loan',
                                'saturation deduction',
                                'other payment',
                                'overtime',
                                'set salary',
                                'pay slip',
                                'company policy',
                                'appraisal',
                                'goal tracking',
                                'goal type',
                                'indicator',
                                'event',
                                'meeting',
                                'training',
                                'trainer',
                                'training type',
                                'award',
                                'award type',
                                'resignation',
                                'travel',
                                'promotion',
                                'complaint',
                                'warning',
                                'termination',
                                'termination type',
                                'job application',
                                'job application note',
                                'job onBoard',
                                'job category',
                                'job',
                                'job stage',
                                'custom question',
                                'interview schedule',
                                'estimation',
                                'holiday',
                                'transfer',
                                'announcement',
                                'leave',
                                'leave type',
                                'attendance',
                            ];
                        @endphp

                        <div class="col-md-12">
                            <div class="form-group">
                                @if (!empty($permissions))
                                    <h6 class="my-3">{{ __('Assign HRM related Permission to Roles') }}
                                    </h6>

                                    <table class="table table-striped mb-0" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                {{-- <input type="checkbox" class="form-check-input align-middle custom_align_middle" name="hrm_checkall"  id="hrm_checkall" > --}}
                                                <th>
                                                    <div class="form-check d-flex align-items-center gap-2">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="hrm_checkall" id="hrm_checkall">
                                                        <label for="hrm_checkall" class="form-check-label mb-0">
                                                            {{ __('Select All') }}
                                                        </label>
                                                    </div>
                                                </th>

                                                <th>{{ __('Module') }} </th>
                                                <th>{{ __('Permissions') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @php
                                                $permissionTypes = [
                                                    'view' => 'View',
                                                    'add' => 'Add',
                                                    'move' => 'Move',
                                                    'manage' => 'Manage',
                                                    'create' => 'Create',
                                                    'edit' => 'Edit',
                                                    'delete' => 'Delete',
                                                    'show' => 'Show',
                                                    'send' => 'Send',
                                                    'create payment' => 'Create Payment',
                                                    'delete payment' => 'Delete Payment',
                                                    'income' => 'Income',
                                                    'expense' => 'Expense',
                                                    'income vs expense' => 'Income VS Expense',
                                                    'loss & profit' => 'Loss & Profit',
                                                    'tax' => 'Tax',
                                                    'invoice' => 'Invoice',
                                                    'bill' => 'Bill',
                                                ];
                                            @endphp
                                            @foreach ($modules as $module)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input align-middle ischeck hrm_checkall"
                                                            data-id="{{ str_replace(' ', '', $module) }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck hrm_checkall"
                                                            data-id="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($permissionTypes as $type => $label)
                                                                @php
                                                                    $permission = $type . ' ' . $module;
                                                                    $key = array_search($permission, $permissions);
                                                                @endphp
                                                                @if ($key !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            id="permission{{ $key }}"
                                                                            class="form-check-input isscheck hrm_checkall isscheck_{{ str_replace(' ', '', $module) }}">
                                                                        <label for="permission{{ $key }}"
                                                                            class="custom-control-label">{{ $label }}</label><br>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="pills-contact-tab">
                        @php
                            $modules = [
                                'account dashboard',
                                'proposal',
                                'invoice',
                                'bill',
                                'revenue',
                                'payment',
                                'proposal product',
                                'invoice product',
                                'bill product',
                                'goal',
                                'credit note',
                                'debit note',
                                'bank account',
                                'bank transfer',
                                'transaction',
                                'customer',
                                'vender',
                                'constant custom field',
                                'assets',
                                'chart of account',
                                'journal entry',
                                'report',
                            ];
                        @endphp
                        <div class="col-md-12">
                            <div class="form-group">
                                @if (!empty($permissions))
                                    <h6 class="my-3">{{ __('Assign Account related Permission to Roles') }}</h6>
                                    <table class="table table-striped mb-0" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                {{-- <th>
                                        <input type="checkbox" class="form-check-input custom_align_middle" name="account_checkall"  id="account_checkall" >
                                    </th> --}}
                                                <th>
                                                    <div class="form-check d-flex align-items-center gap-2">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="account_checkall" id="account_checkall">
                                                        <label for="account_checkall" class="form-check-label mb-0">
                                                            {{ __('Select All') }}
                                                        </label>
                                                    </div>
                                                </th>
                                                <th>{{ __('Module') }} </th>
                                                <th>{{ __('Permissions') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                                $actions = [
                                                    'view' => 'View',
                                                    'add' => 'Add',
                                                    'move' => 'Move',
                                                    'manage' => 'Manage',
                                                    'create' => 'Create',
                                                    'edit' => 'Edit',
                                                    'delete' => 'Delete',
                                                    'show' => 'Show',
                                                    'send' => 'Send',
                                                    'create payment' => 'Create Payment',
                                                    'delete payment' => 'Delete Payment',
                                                    'income' => 'Income',
                                                    'expense' => 'Expense',
                                                    'loss & profit' => 'Loss & Profit',
                                                    'tax' => 'Tax',
                                                    'invoice' => 'Invoice',
                                                    'bill' => 'Bill',
                                                    'duplicate' => 'Duplicate',
                                                ];
                                            @endphp

                                            @foreach ($modules as $module)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input ischeck account_checkall"
                                                            data-id="{{ str_replace(' ', '', $module) }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck"
                                                            data-id="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($actions as $actionKey => $actionLabel)
                                                                @php
                                                                    $fullPermission = $actionKey . ' ' . $module;
                                                                    $key = array_search($fullPermission, $permissions);
                                                                @endphp

                                                                @if ($key !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            class="form-check-input isscheck account_checkall isscheck_{{ str_replace(' ', '', $module) }}"
                                                                            id="permission{{ $key }}">
                                                                        <label for="permission{{ $key }}"
                                                                            class="custom-control-label">
                                                                            {{ $actionLabel }}
                                                                        </label>
                                                                        <br>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pos" role="tabpanel" aria-labelledby="pills-contact-tab">
                        @php
                            $modules = ['warehouse', 'quotation', 'purchase', 'pos', 'barcode'];
                        @endphp
                        <div class="col-md-12">
                            <div class="form-group">
                                @if (!empty($permissions))
                                    <h6 class="my-3">{{ __('Assign POS related Permission to Roles') }}</h6>
                                    <table class="table table-striped mb-0" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox"
                                                        class="form-check-input custom_align_middle"
                                                        name="pos_checkall" id="pos_checkall">
                                                </th>
                                                <th>{{ __('Module') }} </th>
                                                <th>{{ __('Permissions') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($modules as $module)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input ischeck pos_checkall"
                                                            data-id="{{ str_replace(' ', '', $module) }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck"
                                                            data-id="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @php $mod = str_replace(' ', '', $module); @endphp

                                                            @foreach ($permissions as $key => $permission)
                                                                @php
                                                                    $actions = [
                                                                        'view' => 'View',
                                                                        'add' => 'Add',
                                                                        'manage' => 'Manage',
                                                                        'create' => 'Create',
                                                                        'edit' => 'Edit',
                                                                        'delete' => 'Delete',
                                                                        'show' => 'Show',
                                                                        'send' => 'Send',
                                                                        'convert' => 'Convert',
                                                                        'create payment' => 'Create Payment',
                                                                        'delete payment' => 'Delete Payment',
                                                                    ];
                                                                @endphp

                                                                @foreach ($actions as $action => $label)
                                                                    @if ($permission == "$action $module")
                                                                        <div
                                                                            class="col-md-3 custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                name="permissions[]"
                                                                                value="{{ $key }}"
                                                                                class="form-check-input isscheck pos_checkall isscheck_{{ $mod }}"
                                                                                id="permission{{ $key }}">
                                                                            <label for="permission{{ $key }}"
                                                                                class="custom-control-label">
                                                                                {{ $label }}
                                                                            </label>
                                                                            <br>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn  btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
    </div>


</form>
<script>
    $(document).ready(function() {
        $("#staff_checkall").click(function() {
            $('.staff_checkall').not(this).prop('checked', this.checked);
        });
        $("#crm_checkall").click(function() {
            $('.crm_checkall').not(this).prop('checked', this.checked);
        });
        $("#project_checkall").click(function() {
            $('.project_checkall').not(this).prop('checked', this.checked);
        });
        $("#hrm_checkall").click(function() {
            $('.hrm_checkall').not(this).prop('checked', this.checked);
        });
        $("#account_checkall").click(function() {
            $('.account_checkall').not(this).prop('checked', this.checked);
        });
        $("#pos_checkall").click(function() {
            $('.pos_checkall').not(this).prop('checked', this.checked);
        });
        $(".ischeck").click(function() {
            var ischeck = $(this).data('id');
            $('.isscheck_' + ischeck).prop('checked', this.checked);
        });
    });
</script>
