@php
    use App\Models\Utility;
    $setting = \App\Models\Utility::settings();
    // $logo = \App\Models\Utility::get_file('uploads/logo');
    $logo = Storage::url('uploads/logo');

    $company_logo = $setting['company_logo_dark'] ?? '';
    $company_logos = $setting['company_logo_light'] ?? '';
    $company_small_logo = $setting['company_small_logo'] ?? '';
    $emailTemplate = \App\Models\EmailTemplate::emailTemplateData();
    $lang = Auth::user()->lang;
    $userPlan = \App\Models\Plan::getPlan(\Auth::user()->show_dashboard());
@endphp

@if (isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'off')
    <nav class="dash-sidebar light-sidebar transprent-bg">
    @else
        <nav class="dash-sidebar light-sidebar ">
@endif
<div class="navbar-wrapper bg-transparent bg-gradient">
    <div class="m-header main-logo">
        <a href="#" class="b-brand">
            @if ($setting['cust_darklayout'] && $setting['cust_darklayout'] == 'on')
                <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                    alt="{{ config('app.name') }}" class="logo logo-lg">
            @else
                <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-light.png') }}"
                    alt="{{ config('app.name') }}" class="logo logo-lg">
            @endif

        </a>
    </div>
    <div class="navbar-content">
        @if (\Auth::user()->type != 'client')
            <ul class="dash-navbar">
                <!--------------------- Start Dashboard ----------------------------------->
                @if (Gate::check('show hrm dashboard') ||
                        Gate::check('show project dashboard') ||
                        Gate::check('show account dashboard') ||
                        Gate::check('show crm dashboard') ||
                        Gate::check('show pos dashboard'))
                    <li
                        class="dash-item dash-hasmenu
                                {{ Request::segment(1) == null ||
                                Request::segment(1) == 'account-dashboard' ||
                                Request::segment(1) == 'income report' ||
                                Request::segment(1) == 'report' ||
                                Request::segment(1) == 'reports-monthly-cashflow' ||
                                Request::segment(1) == 'reports-quarterly-cashflow' ||
                                Request::segment(1) == 'reports-payroll' ||
                                Request::segment(1) == 'reports-leave' ||
                                Request::segment(1) == 'reports-monthly-attendance' ||
                                Request::segment(1) == 'reports-lead' ||
                                Request::segment(1) == 'reports-deal' ||
                                Request::segment(1) == 'pos-dashboard' ||
                                Request::segment(1) == 'reports-warehouse' ||
                                Request::segment(1) == 'reports-daily-purchase' ||
                                Request::segment(1) == 'reports-monthly-purchase' ||
                                Request::segment(1) == 'reports-daily-pos' ||
                                Request::segment(1) == 'reports-monthly-pos' ||
                                Request::segment(1) == 'reports-pos-vs-purchase'
                                    ? 'active dash-trigger'
                                    : '' }}">
                        <a href='#' class="dash-link ">
                            <span class="dash-micon">
                                <i class="ti ti-home"></i>
                            </span>
                            <span class="dash-mtext">{{ __('Dashboard') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @if ($userPlan->account == 1 && Gate::check('show account dashboard'))
                                <li
                                    class="dash-item dash-hasmenu {{ Request::segment(1) == null || Request::segment(1) == 'account-dashboard' || Request::segment(1) == 'report' || Request::segment(1) == 'reports-monthly-cashflow' || Request::segment(1) == 'reports-quarterly-cashflow' ? ' active dash-trigger' : '' }}">
                                    <a class="dash-link" href="#">{{ __('Accounting ') }}<span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul class="dash-submenu">
                                        @can('show account dashboard')
                                            <li
                                                class="dash-item {{ Request::segment(1) == null || Request::segment(1) == 'account-dashboard' ? ' active' : '' }}">
                                                <a class="dash-link"
                                                    href="{{ route('dashboard') }}">{{ __(' Overview') }}</a>
                                            </li>
                                        @endcan
                                        @if (Gate::check('income report') ||
                                                Gate::check('expense report') ||
                                                Gate::check('income vs expense report') ||
                                                Gate::check('tax report') ||
                                                Gate::check('loss & profit report') ||
                                                Gate::check('invoice report') ||
                                                Gate::check('bill report') ||
                                                Gate::check('stock report') ||
                                                Gate::check('invoice report') ||
                                                Gate::check('manage transaction') ||
                                                Gate::check('statement report'))
                                            <li
                                                class="dash-item dash-hasmenu {{ Request::segment(1) == 'report' || Request::segment(1) == 'reports-monthly-cashflow' || Request::segment(1) == 'reports-quarterly-cashflow' ? 'active dash-trigger ' : '' }}">
                                                <a class="dash-link" href="#">{{ __('Reports') }}<span
                                                        class="dash-arrow"><i
                                                            data-feather="chevron-right"></i></span></a>
                                                <ul class="dash-submenu">
                                                    @can('statement report')
                                                        <li
                                                            class="dash-item {{ Request::route()->getName() == 'report.account.statement' ? ' active' : '' }}">
                                                            <a class="dash-link"
                                                                href="#">{{ __('Account Statement') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('invoice report')
                                                        <li
                                                            class="dash-item {{ Request::route()->getName() == 'report.invoice.summary' ? ' active' : '' }}">
                                                            <a class="dash-link"
                                                                href="#">{{ __('Invoice Summary') }}</a>
                                                        </li>
                                                    @endcan
                                                    <li
                                                        class="dash-item {{ Request::route()->getName() == 'report.sales' ? ' active' : '' }}">
                                                        <a class="dash-link"
                                                            href="#">{{ __('Sales Report') }}</a>
                                                    </li>
                                                    <li
                                                        class="dash-item {{ Request::route()->getName() == 'report.receivables' ? ' active' : '' }}">
                                                        <a class="dash-link" href="#">{{ __('Receivables') }}</a>
                                                    </li>
                                                    <li
                                                        class="dash-item {{ Request::route()->getName() == 'report.payables' ? ' active' : '' }}">
                                                        <a class="dash-link" href="#">{{ __('Payables') }}</a>
                                                    </li>
                                                    @can('bill report')
                                                        <li
                                                            class="dash-item {{ Request::route()->getName() == 'report.bill.summary' ? ' active' : '' }}">
                                                            <a class="dash-link"
                                                                href="#">{{ __('Bill Summary') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('stock report')
                                                        <li
                                                            class="dash-item {{ Request::route()->getName() == 'report.product.stock.report' ? ' active' : '' }}">
                                                            <a href="#"
                                                                class="dash-link">{{ __('Product Stock') }}</a>
                                                        </li>
                                                    @endcan

                                                    @can('loss & profit report')
                                                        <li
                                                            class="dash-item {{ request()->is('reports-monthly-cashflow') || request()->is('reports-quarterly-cashflow') ? 'active' : '' }}">
                                                            <a class="dash-link" href="#">{{ __('Cash Flow') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage transaction')
                                                        <li
                                                            class="dash-item {{ Request::route()->getName() == 'transaction.index' || Request::route()->getName() == 'transfer.create' || Request::route()->getName() == 'transaction.edit' ? ' active' : '' }}">
                                                            <a class="dash-link" href="#">{{ __('Transaction') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('income report')
                                                        <li
                                                            class="dash-item {{ Request::route()->getName() == 'report.income.summary' ? ' active' : '' }}">
                                                            <a class="dash-link"
                                                                href="#">{{ __('Income Summary') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('expense report')
                                                        <li
                                                            class="dash-item {{ Request::route()->getName() == 'report.expense.summary' ? ' active' : '' }}">
                                                            <a class="dash-link"
                                                                href="#">{{ __('Expense Summary') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('income vs expense report')
                                                        <li
                                                            class="dash-item {{ Request::route()->getName() == 'report.income.vs.expense.summary' ? ' active' : '' }}">
                                                            <a class="dash-link"
                                                                href="#">{{ __('Income VS Expense') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('tax report')
                                                        <li
                                                            class="dash-item {{ Request::route()->getName() == 'report.tax.summary' ? ' active' : '' }}">
                                                            <a class="dash-link" href="#">{{ __('Tax Summary') }}</a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                <!--------------------- End Dashboard ----------------------------------->


                <!--------------------- Start HRM ----------------------------------->

                @if (!empty($userPlan) && $userPlan->hrm == 1)
                    @if (Gate::check('manage employee') || Gate::check('manage setsalary'))
                        <li
                            class="dash-item dash-hasmenu {{ Request::segment(1) == 'holiday-calender' ||
                            Request::segment(1) == 'leavetype' ||
                            Request::segment(1) == 'leave' ||
                            Request::segment(1) == 'attendanceemployee' ||
                            Request::segment(1) == 'document-upload' ||
                            Request::segment(1) == 'document' ||
                            Request::segment(1) == 'performanceType' ||
                            Request::segment(1) == 'branch' ||
                            Request::segment(1) == 'department' ||
                            Request::segment(1) == 'designation' ||
                            Request::segment(1) == 'employee' ||
                            Request::segment(1) == 'leave_requests' ||
                            Request::segment(1) == 'holidays' ||
                            Request::segment(1) == 'policies' ||
                            Request::segment(1) == 'leave_calender' ||
                            Request::segment(1) == 'award' ||
                            Request::segment(1) == 'transfer' ||
                            Request::segment(1) == 'resignation' ||
                            Request::segment(1) == 'training' ||
                            Request::segment(1) == 'travel' ||
                            Request::segment(1) == 'promotion' ||
                            Request::segment(1) == 'complaint' ||
                            Request::segment(1) == 'warning' ||
                            Request::segment(1) == 'termination' ||
                            Request::segment(1) == 'announcement' ||
                            Request::segment(1) == 'job' ||
                            Request::segment(1) == 'job-application' ||
                            Request::segment(1) == 'candidates-job-applications' ||
                            Request::segment(1) == 'job-onboard' ||
                            Request::segment(1) == 'custom-question' ||
                            Request::segment(1) == 'interview-schedule' ||
                            Request::segment(1) == 'career' ||
                            Request::segment(1) == 'holiday' ||
                            Request::segment(1) == 'setsalary' ||
                            Request::segment(1) == 'payslip' ||
                            Request::segment(1) == 'paysliptype' ||
                            Request::segment(1) == 'company-policy' ||
                            Request::segment(1) == 'job-stage' ||
                            Request::segment(1) == 'job-category' ||
                            Request::segment(1) == 'terminationtype' ||
                            Request::segment(1) == 'awardtype' ||
                            Request::segment(1) == 'trainingtype' ||
                            Request::segment(1) == 'goaltype' ||
                            Request::segment(1) == 'paysliptype' ||
                            Request::segment(1) == 'allowanceoption' ||
                            Request::segment(1) == 'competencies' ||
                            Request::segment(1) == 'loanoption' ||
                            Request::segment(1) == 'deductionoption'
                                ? 'active dash-trigger'
                                : '' }}">
                            <a href="#!" class="dash-link ">
                                <span class="dash-micon">
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="dash-mtext">
                                    {{ __('HRM System') }}
                                </span>
                                <span class="dash-arrow">
                                    <i data-feather="chevron-right"></i>
                                </span>
                            </a>
                            <ul class="dash-submenu">
                                <li
                                    class="dash-item  {{ Request::segment(1) == 'employee' ? 'active dash-trigger' : '' }}   ">
                                    @if (auth()->user()->type == 'Employee')
                                        @php
                                            $employee = App\Models\Employees::where(
                                                'user_id',
                                                \Auth::user()->id,
                                            )->first();
                                            // print_r($employee);die;
                                        @endphp
                                        <a class="dash-link"
                                            href="{{ route('employee.index') }}">{{ __('Employee') }}</a>
                                    @else
                                        <a href="{{ route('employee.index') }}" class="dash-link">
                                            {{ __('Employee Setup') }}
                                        </a>
                                    @endif
                                </li>

                                @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'HR')
                                    <li
                                        class="dash-item {{ Request::segment(1) == 'leavetype' ||
                                        Request::segment(1) == 'document' ||
                                        Request::segment(1) == 'performanceType' ||
                                        Request::segment(1) == 'branch' ||
                                        Request::segment(1) == 'department' ||
                                        Request::segment(1) == 'designation' ||
                                        Request::segment(1) == 'job-stage' ||
                                        Request::segment(1) == 'performanceType' ||
                                        Request::segment(1) == 'job-category' ||
                                        Request::segment(1) == 'terminationtype' ||
                                        Request::segment(1) == 'awardtype' ||
                                        Request::segment(1) == 'trainingtype' ||
                                        Request::segment(1) == 'goaltype' ||
                                        Request::segment(1) == 'paysliptype' ||
                                        Request::segment(1) == 'allowanceoption' ||
                                        Request::segment(1) == 'loanoption' ||
                                        Request::segment(1) == 'deductionoption'
                                            ? 'active dash-trigger'
                                            : '' }}">
                                        <a class="dash-link"
                                            href="{{ route('branch.index') }}">{{ __('HRM System Setup') }}</a>
                                    </li>
                                @endcan

                                     @if (Gate::check('manage set salary') || Gate::check('manage pay slip'))
                                    <li
                                        class="dash-item dash-hasmenu  {{ Request::segment(1) == 'setsalary' || Request::segment(1) == 'payslip' ? 'active dash-trigger' : '' }}">
                                        <a class="dash-link" href="#">{{ __('Payroll Setup') }}<span
                                                class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            @can('manage set salary')
                                                <li
                                                    class="dash-item {{ request()->is('setsalary*') ? 'active' : '' }}">
                                                    <a class="dash-link"
                                                        href="{{ route('setsalary.index') }}">{{ __('Set salary') }}</a>
                                                </li>
                                            @endcan
                                            @can('manage pay slip')
                                                <li class="dash-item {{ request()->is('payslip*') ? 'active' : '' }}">
                                                    <a class="dash-link"
                                                        href="#">{{ __('Payslip') }}</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endif


                        </ul>
                    </li>
                @endif
            @endif

            <!--------------------- End HRM ----------------------------------->








            <!--------------------- Start User Managaement System ----------------------------------->

            @if (
                \Auth::user()->type != 'super admin' &&
                    (Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage client')))
                <li
                    class="dash-item dash-hasmenu {{ Request::segment(1) == 'users' ||
                    Request::segment(1) == 'roles' ||
                    Request::segment(1) == 'clients' ||
                    Request::segment(1) == 'userlogs'
                        ? ' active dash-trigger'
                        : '' }}">

                    <a href="#!" class="dash-link "><span class="dash-micon"><i
                                class="ti ti-users"></i></span><span
                            class="dash-mtext">{{ __('User Management') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        @can('manage user')
                            <li
                                class="dash-item {{ Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' || Request::route()->getName() == 'user.userlog' ? ' active' : '' }}">
                                <a class="dash-link" href="{{ route('users.index') }}">{{ __('User') }}</a>
                            </li>
                            {{-- <h1>Users</h1> --}}
                        @endcan
                        @can('manage role')

                        @php
                        $activeRoutes = ['roles.index', 'roles.create', 'roles.edit'];
                        @endphp
                        <li class="dash-item {{ in_array(Request::route()->getName(), $activeRoutes) ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Role') }}</a>
                        </li>
                        @endcan
                        @can('manage client')
                            <li
                                class="dash-item {{ Request::route()->getName() == 'clients.index' || Request::segment(1) == 'clients' || Request::route()->getName() == 'clients.edit' ? ' active' : '' }}">
                                <a class="dash-link" href="{{route('clients.index')}}">{{ __('Client') }}</a>
                            </li>
                        @endcan
                        {{--                                    @can('manage user') --}}
                        {{--                                        <li class="dash-item {{ (Request::route()->getName() == 'users.index' || Request::segment(1) == 'users' || Request::route()->getName() == 'users.edit') ? ' active' : '' }}"> --}}
                        {{--                                            <a class="dash-link" href="{{ route('user.userlog') }}">{{__('User Logs')}}</a> --}}
                        {{--                                        </li> --}}
                        {{--                                    @endcan --}}
                    </ul>
                </li>
            @endif

            <!--------------------- End User Managaement System----------------------------------->









            <!--------------------- Start System Setup ----------------------------------->


        </ul>
    @endif
    @if (\Auth::user()->type == 'client')
        <ul class="dash-navbar">
            @if (Gate::check('manage client dashboard'))
                <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'dashboard' ? ' active' : '' }}">
                    <a href="#" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-home"></i></span><span
                            class="dash-mtext">{{ __('Dashboard') }}</span>
                    </a>
                </li>
            @endif
            @if (Gate::check('manage deal'))
                <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'deals' ? ' active' : '' }}">
                    <a href="#" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-rocket"></i></span><span
                            class="dash-mtext">{{ __('Deals') }}</span>
                    </a>
                </li>
            @endif
            @if (Gate::check('manage contract'))
                <li
                    class="dash-item dash-hasmenu {{ Request::route()->getName() == 'contract.index' || Request::route()->getName() == 'contract.show' ? 'active' : '' }}">
                    <a href="#" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-rocket"></i></span><span
                            class="dash-mtext">{{ __('Contract') }}</span>
                    </a>
                </li>
            @endif
            @if (Gate::check('manage project'))
                <li class="dash-item dash-hasmenu  {{ Request::segment(1) == 'projects' ? ' active' : '' }}">
                    <a href="#" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-share"></i></span><span
                            class="dash-mtext">{{ __('Project') }}</span>
                    </a>
                </li>
            @endif
            @if (Gate::check('manage project'))
                <li
                    class="dash-item  {{ Request::route()->getName() == 'project_report.index' || Request::route()->getName() == 'project_report.show' ? 'active' : '' }}">
                    <a class="dash-link" href="#">
                        <span class="dash-micon"><i class="ti ti-chart-line"></i></span><span
                            class="dash-mtext">{{ __('Project Report') }}</span>
                    </a>
                </li>
            @endif

            @if (Gate::check('manage project task'))
                <li class="dash-item dash-hasmenu  {{ Request::segment(1) == 'taskboard' ? ' active' : '' }}">
                    <a href="#" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-list-check"></i></span><span
                            class="dash-mtext">{{ __('Tasks') }}</span>
                    </a>
                </li>
            @endif

            @if (Gate::check('manage bug report'))
                <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'bugs-report' ? ' active' : '' }}">
                    <a href="#" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-bug"></i></span><span
                            class="dash-mtext">{{ __('Bugs') }}</span>
                    </a>
                </li>
            @endif

            @if (Gate::check('manage timesheet'))
                <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'timesheet-list' ? ' active' : '' }}">
                    <a href="#" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-clock"></i></span><span
                            class="dash-mtext">{{ __('Timesheet') }}</span>
                    </a>
                </li>
            @endif

            @if (Gate::check('manage project task'))
                <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'calendar' ? ' active' : '' }}">
                    <a href="#" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-calendar"></i></span><span
                            class="dash-mtext">{{ __('Task Calender') }}</span>
                    </a>
                </li>
            @endif

            <li class="dash-item dash-hasmenu">
            <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'support' ? 'active' : '' }}">
                <a href="#" class="dash-link">
                    <span class="dash-micon"><i class="ti ti-headphones"></i></span><span
                        class="dash-mtext">{{ __('Support System') }}</span>
                </a>
            </li>
            </li>
        </ul>
    @endif
    @if (\Auth::user()->type == 'super admin')
        <ul class="dash-navbar">
            @if (Gate::check('manage super admin dashboard'))
                <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'dashboard' ? ' active' : '' }}">
                    <a href="{{ route('client.dashboard.view') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-home"></i></span><span
                            class="dash-mtext">{{ __('Dashboard') }}</span>
                    </a>
                </li>
            @endif


            @can('manage user')
                <li
                    class="dash-item dash-hasmenu {{ Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' ? ' active' : '' }}">
                    <a href="{{ route('users.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span><span
                            class="dash-mtext">{{ __('Companies') }}</span>
                    </a>
                </li>
            @endcan



            <li
                class="dash-item dash-hasmenu {{ Request::segment(1) == 'email_template' || Request::route()->getName() == 'manage.email.language' ? ' active dash-trigger' : 'collapsed' }}">
                <a href="{{ route('manage.email.language', [$emailTemplate->id, auth()->user()->lang]) }}"
                    class="dash-link">
                    <span class="dash-micon"><i class="ti ti-template"></i></span>
                    <span class="dash-mtext">{{ __('Email Template') }}</span>
                </a>
            </li>
            @if (Gate::check('manage system settings'))
                <li
                    class="dash-item dash-hasmenu {{ Request::route()->getName() == 'systems.index' ? ' active' : '' }}">
                    <a href="{{ route('systems.index') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-settings"></i></span><span
                            class="dash-mtext">{{ __('Settings') }}</span>
                    </a>
                </li>
            @endif

        </ul>
    @endif
</div>
</div>
</nav>
