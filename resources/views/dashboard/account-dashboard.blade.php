@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('script-page')
<script>
    (function () {
        var chartBarOptions = {
            series: [
                {
                    name: "Income",
                    data: [5000, 7000, 8000, 6000, 7500] // Static Income Data
                },
                {
                    name: "Expense",
                    data: [3000, 4000, 6000, 5000, 6500] // Static Expense Data
                }
            ],
            chart: {
                height: 250,
                type: 'area',
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                toolbar: { show: false }
            },
            xaxis: {
                categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                title: { text: 'Date' }
            },
            colors: ['#6fd944', '#ff3a6e']
        };
        var arChart = new ApexCharts(document.querySelector("#cash-flow"), chartBarOptions);
        arChart.render();
    })();

    (function () {
        var options = {
            series: [
                {
                    name: "Income",
                    data: [4000, 6000, 7000] // Static Income Data
                },
                {
                    name: "Expense",
                    data: [2000, 3000, 5000] // Static Expense Data
                }
            ],
            chart: {
                height: 180,
                type: 'bar'
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar'],
            },
            colors: ['#3ec9d6', '#FF3A6E']
        };
        var chart = new ApexCharts(document.querySelector("#incExpBarChart"), options);
        chart.render();
    })();

    (function () {
        var options = {
            series: [40, 30, 20, 10], // Static Expense Data
            colors: ['#ff3a6e', '#3ec9d6', '#6fd944', '#ffab00'],
            labels: ['Rent', 'Utilities', 'Supplies', 'Others']
        };
        var chart = new ApexCharts(document.querySelector("#expenseByCategory"), options);
        chart.render();
    })();

    (function () {
        var options = {
            series: [50, 20, 15, 15], // Static Income Data
            colors: ['#6FD943', '#3ec9d6', '#ff3a6e', '#ffab00'],
            labels: ['Salary', 'Investments', 'Bonus', 'Other']
        };
        var chart = new ApexCharts(document.querySelector("#incomeByCategory"), options);
        chart.render();
    })();

    (function () {
        var options = {
            series: [70], // Static Storage Data
            chart: {
                height: 350,
                type: 'radialBar'
            },
            colors: ["#6FD943"],
            labels: ['Used']
        };
        var chart = new ApexCharts(document.querySelector("#limit-chart"), options);
        chart.render();
    })();
</script>

@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Account')}}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-7">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="theme-avtar bg-primary badge">
                                                <i class="ti ti-users"></i>
                                            </div>
                                            <p class="text-muted text-sm mt-4 mb-2">{{__('Total')}}</p>
                                            <h6 class="mb-3"><a href="#" class="dashboard-link">{{__('Customers')}}</a></h6>
                                            <h3 class="mb-0">100</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="theme-avtar bg-info badge">
                                                <i class="ti ti-users"></i>
                                            </div>
                                            <p class="text-muted text-sm mt-4 mb-2">{{__('Total')}}</p>
                                            <h6 class="mb-3"><a href="#" class="dashboard-link">{{__('Vendors')}}</a></h6>
                                            <h3 class="mb-0">50
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="theme-avtar bg-warning badge">
                                                <i class="ti ti-report-money"></i>
                                            </div>
                                            <p class="text-muted text-sm mt-4 mb-2">{{__('Total')}}</p>
                                            <h6 class="mb-3"><a href="#" class="dashboard-link">{{__('Invoices')}}</a></h6>
                                            <h3 class="mb-0">65</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="theme-avtar bg-danger badge">
                                                <i class="ti ti-report-money"></i>
                                            </div>
                                            <p class="text-muted text-sm mt-4 mb-2">{{__('Total')}}</p>
                                            <h6 class="mb-3"><a href="#" class="dashboard-link">{{__('Bills')}}</a></h6>
                                            <h3 class="mb-0">2500</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__('Income & Expense')}}
                                        <span class="float-end text-muted">{{__('Current Year')}}</span>
                                    </h5>

                                </div>
                                <div class="card-body">
                                    <div id="incExpBarChart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Account Balance')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>{{__('Bank')}}</th>
                                                <th>{{__('Holder Name')}}</th>
                                                <th>{{__('Balance')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>



                                            <tr class="font-style">
                                                <td>ABC Bank</td>
                                                <td>John Doe</td>
                                                <td>$10,000</td>
                                            </tr>

                                            <tr class="font-style">
                                                <td>XYZ Bank</td>
                                                <td>Jane Smith</td>
                                                <td>$5,000</td>
                                            </tr>
                                            <tr class="font-style">
                                                <td>DEF Bank</td>
                                                <td>Michael Johnson</td>
                                                <td>$3,000</td>
                                            </tr>

                                            {{-- @empty --}}
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="text-center">
                                                            <h6>{{__('there is no account balance')}}</h6>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Latest Income')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Customer')}}</th>
                                                <th>{{__('Amount Due')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td colspan="4">
                                                        <div class="text-center">
                                                            <h6>{{__('There is no latest income')}}</h6>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Latest Expense')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Vendor')}}</th>
                                                <th>{{__('Amount Due')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td colspan="4">
                                                        <div class="text-center">
                                                            <h6>{{__('There is no latest expense')}}</h6>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Recent Invoices')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('Customer')}}</th>
                                                <th>{{__('Issue Date')}}</th>
                                                <th>{{__('Due Date')}}</th>
                                                <th>{{__('Amount')}}</th>
                                                <th>{{__('Status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td colspan="6">
                                                        <div class="text-center">
                                                            <h6>{{__('There is no recent invoice')}}</h6>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Recent Bills')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('Vendor')}}</th>
                                                <th>{{__('Bill Date')}}</th>
                                                <th>{{__('Due Date')}}</th>
                                                <th>{{__('Amount')}}</th>
                                                <th>{{__('Status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td colspan="6">
                                                        <div class="text-center">
                                                            <h6>{{__('There is no recent bill')}}</h6>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Cashflow')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div id="cash-flow"></div>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mt-1 mb-0">{{__('Income Vs Expense')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-6 my-2">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="theme-avtar bg-primary badge">
                                                    <i class="ti ti-report-money"></i>
                                                </div>
                                                <div class="ms-2">
                                                    <p class="text-muted text-sm mb-0">{{__('Income Today')}}</p>
                                                    <h4 class="mb-0 text-primary">500</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 my-2">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="theme-avtar bg-info badge">
                                                    <i class="ti ti-file-invoice"></i>
                                                </div>
                                                <div class="ms-2">
                                                    <p class="text-muted text-sm mb-0">{{__('Expense Today')}}</p>
                                                    <h4 class="mb-0 text-info">1000</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 my-2">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="theme-avtar bg-warning badge">
                                                    <i class="ti ti-report-money"></i>
                                                </div>
                                                <div class="ms-2">
                                                    <p class="text-muted text-sm mb-0">{{__('Income This Month')}}</p>
                                                        <h4 class="mb-0 text-warning">1200</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 my-2">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="theme-avtar bg-danger badge">
                                                    <i class="ti ti-file-invoice"></i>
                                                </div>
                                                <div class="ms-2">
                                                    <p class="text-muted text-sm mb-0">{{__('Expense This Month')}}</p>
                                                    <h4 class="mb-0 text-danger">60000</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__('Storage Limit')}}
                                       <span class="float-end text-muted">{{__('Year')}}</span>
                                        <small class="float-end text-muted">500GB/1000GB</small>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="limit-chart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__('Income By Category')}}
                                        <span class="float-end text-muted">{{__('Year')}}</span>

                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="incomeByCategory"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__('Expense By Category')}}
                                        <span class="float-end text-muted">{{__('Year')}}</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="expenseByCategory"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#invoice_weekly_statistics" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Invoices Weekly Statistics')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#invoice_monthly_statistics" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Invoices Monthly Statistics')}}</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="invoice_weekly_statistics" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0 ">
                                                    <tbody class="list">
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Invoice Generated')}}</p>

                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">---</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Paid')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">----</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Due')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">----</h4>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="invoice_monthly_statistics" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0 ">
                                                    <tbody class="list">
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Invoice Generated')}}</p>

                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">-----</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Paid')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">---</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Due')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">----</h4>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#bills_weekly_statistics" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Bills Weekly Statistics')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#bills_monthly_statistics" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Bills Monthly Statistics')}}</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="bills_weekly_statistics" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0 ">
                                                    <tbody class="list">
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Bill Generated')}}</p>

                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">7000</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Paid')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">500</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Due')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">66</h4>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="bills_monthly_statistics" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0 ">
                                                    <tbody class="list">
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Bill Generated')}}</p>

                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">10000</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Paid')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">50000</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5 class="mb-0">{{__('Total')}}</h5>
                                                            <p class="text-muted text-sm mb-0">{{__('Due')}}</p>
                                                        </td>
                                                        <td>
                                                            <h4 class="text-muted">400</h4>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{__('Goal')}}</h5>
                        </div>
                        <div class="card-body">
                            {{-- @forelse($goals as $goal)
                                @php
                                    $total= $goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['total'];
                                    $percentage=$goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['percentage'];
                                    $per=number_format($goal->target($goal->type,$goal->from,$goal->to,$goal->amount)['percentage'], Utility::getValByName('decimal_number'), '.', '');
                                @endphp --}}
                                <div class="card border-success border-2 border-bottom-0 border-start-0 border-end-0">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <label class="form-check-label d-block" for="customCheckdef1">
                                                <span>
                                                    <span class="row align-items-center">
                                                        <span class="col">
                                                            <span class="text-muted text-sm">{{__('Name')}}</span>
                                                            <h6 class="text-nowrap mb-3 mb-sm-0">GoalName</h6>
                                                        </span>
                                                        <span class="col">
                                                            <span class="text-muted text-sm">{{__('Type')}}</span>
                                                            <h6 class="mb-3 mb-sm-0">Reach 1 billion</h6>
                                                        </span>
                                                        <span class="col">
                                                            <span class="text-muted text-sm">{{__('Duration')}}</span>
                                                            <h6 class="mb-3 mb-sm-0">duration</h6>
                                                        </span>
                                                        <span class="col">
                                                            <span class="text-muted text-sm">{{__('Target')}}</span>
                                                            <h6 class="mb-3 mb-sm-0">---</h6>
                                                        </span>
                                                        <span class="col">
                                                            <span class="text-muted text-sm">{{__('Progress')}}</span>
                                                            <h6 class="mb-2 d-block">----</h6>
                                                            <div class="progress mb-0">
                                                                {{-- @if($per<=33)
                                                                    <div class="progress-bar bg-danger" style="width: {{$per}}%"></div>
                                                                @elseif($per>=33 && $per<=66)
                                                                    <div class="progress-bar bg-warning" style="width: {{$per}}%"></div>
                                                                @else
                                                                    <div class="progress-bar bg-primary" style="width: {{$per}}%"></div>
                                                                @endif --}}
                                                            </div>
                                                        </span>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                {{-- @empty --}}
                                <div class="card pb-0">
                                    <div class="card-body text-center">
                                        <h6>{{__('There is no goal.')}}</h6>
                                    </div>
                                </div>
                            {{-- @endforelse --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        if(window.innerWidth <= 500)
        {
            $('p').removeClass('text-sm');
        }
    </script>
@endpush
