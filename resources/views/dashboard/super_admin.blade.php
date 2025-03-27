@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection

@push('theme-script')
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
@endpush
@push('script-page')
    <script>
        (function () {
            var chartBarOptions = {
                series: [
                    {
                        name: '{{ __("Income") }}',
                        data: [1000, 1500, 2000, 2500, 3000, 3500, 4000, 4500, 5000, 5500, 6000, 6500],
                    },
                ],

                chart: {
                    height: 300,
                    type: 'area',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories: [
                        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                    ],
                    title: {
                        text: '{{ __("Months") }}'
                    }
                },
                colors: ['#6fd944', '#6fd944'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                yaxis: {
                    title: {
                        text: '{{ __("Income") }}'
                    },
                }
            };

            var arChart = new ApexCharts(document.querySelector("#chart-sales"), chartBarOptions);
            arChart.render();
        })();
    </script>
@endpush

@php
$admin_payment_setting = \App\Models\Utility::getAdminPaymentSetting();
@endphp

@section('content')
    <div class="row">
    <div class="col-lg-4 col-md-6">
            <div class="card bg-light">
                <div class="card-body p-3 ">
                    <div class="d-flex align-items-center justify-content-between ">
                        <div class="d-flex align-items-center mb-3 mt-3">
                            <div class="theme-avtar bg-danger badge">
                                <i class="ti ti-users"></i>
                            </div>
                            <div class="ms-3 mb-3 mt-3">
                                <h6 class="ml-4">{{__('Total Companies')}}</h6>
                            </div>
                        </div>

                        <div class="number-icon ms-3 mb-3 mt-3"><h3>{{$user->total_user}}</h3></div>
                            <div class="ms-3 mb-3 mt-3">
                                <h6>{{__('Paid Users')}} : {{$user['total_paid_user']}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center mb-3 mt-3">
                            <div class="theme-avtar bg-warning badge">
                                <i class="ti ti-shopping-cart"></i>
                            </div>
                            <div class="ms-3 mb-3 mt-3">
                                <h6 class="ml-4">{{__('Total Orders')}}</h6>
                            </div>
                        </div>

                        <div class="number-icon ms-3 mb-3 mt-3"><h3>{{$user->total_orders}}</h3></div>
                            <div class="ms-3 mb-3 mt-3">
                                <h6>{{__('Total Order Amount')}} : <span class="text-dark">{{isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$'}}{{$user['total_orders_price']}}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center mb-3 mt-3">
                            <div class="theme-avtar bg-info badge">
                                <i class="ti ti-trophy"></i>
                            </div>
                            <div class="ms-3 mb-3 mt-3">
                                <h6 class="ml-4">{{__('Total Plans')}}</h6>
                            </div>
                        </div>

                        <div class="number-icon ms-3 mb-3 mt-3"><h3>{{$user->total_plan}}</h3></div>
                            <div class="ms-3 mb-3 mt-3">
                                <h6>{{__('Most Purchase Plan')}} : <span class="text-dark">{{$user['most_purchese_plan']}}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12">
            <h4 class="h4 font-weight-400">{{__('Recent Order')}}</h4>
            <div class="card">
                <div class="chart">
                    <div id="chart-sales" data-color="primary" data-height="280" class="p-3"></div>
                </div>
            </div>
        </div>
    </div>


@endsection
