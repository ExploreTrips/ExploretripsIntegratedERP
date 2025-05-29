<form action="{{ route('roles.update', $role->id) }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="name" class="form-label">
                        {{ __('Name') }}<x-required></x-required>
                    </label>
                    <input type="text" name="name" id="name" class="form-control"
                        placeholder="{{ __('Enter Role Name') }}" value="{{ old('name',$role->name) }}" required>
                    @error('name')
                        <small class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-staff-tab" data-bs-toggle="pill" href="#staff"
                            role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Staff') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-crm-tab" data-bs-toggle="pill" href="#crm" role="tab"
                            aria-controls="pills-profile" aria-selected="false">{{ __('CRM') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-project-tab" data-bs-toggle="pill" href="#project" role="tab"
                            aria-controls="pills-contact" aria-selected="false">{{ __('Project') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-hrmpermission-tab" data-bs-toggle="pill" href="#hrmpermission"
                            role="tab" aria-controls="pills-contact" aria-selected="false">{{ __('HRM') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-account-tab" data-bs-toggle="pill" href="#account" role="tab"
                            aria-controls="pills-contact" aria-selected="false">{{ __('Account') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-account-tab" data-bs-toggle="pill" href="#pos" role="tab"
                            aria-controls="pills-contact" aria-selected="false">{{ __('POS') }}</a>
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
                                $modules[] = 'language';
                                $modules[] = 'permission';
                            }
                        @endphp
                        <div class="col-md-12">
                            <div class="form-group">
                                @if (!empty($permissions))
                                    <h6 class="my-3">{{ __('Assign General Permission to Roles') }}</h6>
                                    <table class="table table-striped mb-0" id="">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox"
                                                        class="form-check-input align-middle custom_align_middle"
                                                        name="staff_checkall" id="staff_checkall">
                                                </th>
                                                <th>{{ __('Module') }} </th>
                                                <th>{{ __('Permissions') }} </th>
                                            </tr>
                                        </thead>
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
                                                'income vs expense' => 'Income VS Expense',
                                                'loss & profit' => 'Loss & Profit',
                                                'tax' => 'Tax',
                                                'invoice' => 'Invoice',
                                                'bill' => 'Bill',
                                            ];
                                        @endphp

                                        <tbody>
                                            @foreach ($modules as $module)
                                                @php
                                                    $cleanModule = str_replace([' ', '&'], '', $module);
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input align-middle ischeck staff_checkall"
                                                            data-id="{{ $cleanModule }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck staff_checkall"
                                                            data-id="{{ $cleanModule }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($actions as $actionKey => $label)
                                                                @php
                                                                    $fullAction = $actionKey . ' ' . $module;
                                                                    $key = array_search($fullAction, $permissions);
                                                                @endphp

                                                                @if ($key !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            id="permission{{ $key }}"
                                                                            class="form-check-input staff_checkall isscheck_{{ $cleanModule }}"
                                                                            {{ in_array($key, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                                    <table class="table table-striped mb-0" id="">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox"
                                                        class="form-check-input align-middle custom_align_middle"
                                                        name="crm_checkall" id="crm_checkall">
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
                                                    'duplicate' => 'Duplicate',
                                                ];
                                            @endphp

                                            @foreach ($modules as $module)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input align-middle ischeck crm_checkall"
                                                            data-id="{{ str_replace(' ', '', $module) }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck crm_checkall"
                                                            data-id="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($permissionTypes as $prefix => $label)
                                                                @php
                                                                    $key = array_search(
                                                                        "$prefix $module",
                                                                        (array) $permissions,
                                                                    );
                                                                @endphp

                                                                @if ($key !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            id="permission{{ $key }}"
                                                                            class="form-check-input crm_checkall isscheck_{{ str_replace(' ', '', $module) }}"
                                                                            {{ in_array($key, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                                        <label for="permission{{ $key }}"
                                                                            class="custom-control-label">
                                                                            {{ $label }}
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
                                    <table class="table table-striped mb-0" id="">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox"
                                                        class="form-check-input align-middle custom_align_middle"
                                                        name="project_checkall" id="project_checkall">
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
                                                    'duplicate' => 'Duplicate',
                                                ];
                                            @endphp

                                            @foreach ($modules as $module)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input align-middle ischeck project_checkall"
                                                            data-id="{{ str_replace(' ', '', $module) }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck project_checkall"
                                                            data-id="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($permissionTypes as $permKey => $permLabel)
                                                                @php
                                                                    $permString = $permKey . ' ' . $module;
                                                                    $key = array_search($permString, $permissions);
                                                                @endphp

                                                                @if (in_array($permString, (array) $permissions) && $key !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            class="form-check-input project_checkall isscheck_{{ str_replace(' ', '', $module) }}"
                                                                            {{ in_array($key, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}
                                                                            id="permission{{ $key }}">

                                                                        <label for="permission{{ $key }}"
                                                                            class="custom-control-label">
                                                                            {{ $permLabel }}
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
                                    <h6 class="my-3">{{ __('Assign HRM related Permission to Roles') }}</h6>
                                    <table class="table table-striped mb-0" id="">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox"
                                                        class="form-check-input align-middle custom_align_middle"
                                                        name="hrm_checkall" id="hrm_checkall">
                                                </th>
                                                <th>{{ __('Module') }} </th>
                                                <th>{{ __('Permissions') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                                $permissionActions = [
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
                                                    'duplicate' => 'Duplicate',
                                                ];
                                            @endphp

                                            @foreach ($modules as $module)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input align-middle ischeck hrm_checkall"
                                                            data-id="{{ str_replace(' ', '', str_replace('&', '', $module)) }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck hrm_checkall"
                                                            data-id="{{ str_replace(' ', '', str_replace('&', '', $module)) }}">
                                                            {{ ucfirst($module) }}
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($permissionActions as $actionKey => $label)
                                                                @php
                                                                    $permKey = array_search(
                                                                        $actionKey . ' ' . $module,
                                                                        $permissions,
                                                                    );
                                                                @endphp
                                                                @if ($permKey !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $permKey }}"
                                                                            class="form-check-input hrm_checkall isscheck_{{ str_replace(' ', '', str_replace('&', '', $module)) }}"
                                                                            id="permission{{ $permKey }}"
                                                                            {{ in_array($permKey, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                                        <label for="permission{{ $permKey }}"
                                                                            class="custom-control-label">
                                                                            {{ $label }}
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
                                    <table class="table table-striped mb-0" id="">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox"
                                                        class="form-check-input align-middle custom_align_middle"
                                                        name="account_checkall" id="account_checkall">
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
                                                    'duplicate' => 'Duplicate',
                                                ];
                                            @endphp

                                            @foreach ($modules as $module)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input align-middle ischeck account_checkall"
                                                            data-id="{{ str_replace(' ', '', str_replace('&', '', $module)) }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck account_checkall"
                                                            data-id="{{ str_replace(' ', '', str_replace('&', '', $module)) }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($permissionTypes as $type => $label)
                                                                @php
                                                                    $permKey = array_search(
                                                                        $type . ' ' . $module,
                                                                        $permissions,
                                                                    );
                                                                @endphp
                                                                @if ($permKey !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $permKey }}"
                                                                            class="form-check-input account_checkall isscheck_{{ str_replace(' ', '', str_replace('&', '', $module)) }}"
                                                                            id="permission{{ $permKey }}"
                                                                            {{ in_array($permKey, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>

                                                                        <label for="permission{{ $permKey }}"
                                                                            class="custom-control-label">{{ $label }}</label>
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
                                    <table class="table table-striped mb-0" id="">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox"
                                                        class="form-check-input align-middle custom_align_middle"
                                                        name="pos_checkall" id="pos_checkall">
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
                                                    'duplicate' => 'Duplicate',
                                                ];
                                            @endphp

                                            @foreach ($modules as $module)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox"
                                                            class="form-check-input align-middle ischeck pos_checkall"
                                                            data-id="{{ str_replace(' ', '', str_replace('&', '', $module)) }}">
                                                    </td>
                                                    <td>
                                                        <label class="ischeck pos_checkall"
                                                            data-id="{{ str_replace(' ', '', str_replace('&', '', $module)) }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            @foreach ($permissionTypes as $type => $label)
                                                                @php
                                                                    $permKey = array_search(
                                                                        $type . ' ' . $module,
                                                                        $permissions,
                                                                    );
                                                                @endphp
                                                                @if ($permKey !== false)
                                                                    <div
                                                                        class="col-md-3 custom-control custom-checkbox">
                                                                        <input type="checkbox" name="permissions[]"
                                                                            value="{{ $permKey }}"
                                                                            class="form-check-input pos_checkall isscheck_{{ str_replace(' ', '', str_replace('&', '', $module)) }}"
                                                                            id="permission{{ $permKey }}"
                                                                            {{ in_array($permKey, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>

                                                                        <label for="permission{{ $permKey }}"
                                                                            class="custom-control-label">{{ $label }}</label>
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
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn  btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
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
