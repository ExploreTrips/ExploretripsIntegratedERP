@extends('layouts.admin')

@section('title')
    {{ __('Dashboard') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Client') }}</li>
@endsection


@push('theme-script')
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
@endpush

@push('script-page')
    <script>
        (function() {
            var etitle;
            var etype;
            var etypeclass;
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                initialDate: '',
                slotDuration: '00:10:00',
                navLinks: true,
                droppable: true,
                selectable: true,
                selectMirror: true,
                editable: true,
                dayMaxEvents: true,
                handleWindowResize: true,

            });
            calendar.render();
        })();

        $(document).on('click', '.fc-day-grid-event', function(e) {
            if (!$(this).hasClass('deal')) {
                e.preventDefault();
                var event = $(this);
                var title = $(this).find('.fc-content .fc-title').html();
                var size = 'md';
                var url = $(this).attr('href');
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);

                $.ajax({
                    url: url,
                    success: function(data) {
                        $('#commonModal .modal-body').html(data);
                        $("#commonModal").modal('show');
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('error', data.error, 'error')
                    }
                });
            }
        });
    </script>
    <script>
        (function() {
            var chartBarOptions = {
                series: [{
                        name: 'Completed Tasks',
                        data: [10, 20, 30, 40, 50] // Static data
                    },
                    {
                        name: 'Pending Tasks',
                        data: [5, 15, 25, 35, 45] // Static data
                    }
                ]

                chart: {
                    height: 250,
                    type: 'area',
                    // type: 'line',
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
                    categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'], // Static data
                    title: {
                        text: "{{ __('Days') }}"
                    }
                }

                colors: ['#6fd944', '#883617', '#4e37b9', '#8f841b'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                markers: {
                    size: 4,
                    colors: ['#3b6b1d', '#be7713', '#2037dc', '#cbbb27'],
                    opacity: 0.9,
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    title: {
                        text: "{{ __('Amount') }}"
                    },

                }

            };
            var arChart = new ApexCharts(document.querySelector("#chart-sales"), chartBarOptions);
            arChart.render();
        })();



        (function() {
            var options = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: [{
                        name: 'Project A',
                        data: [30, 40, 45, 50, 49]
                    },
                    {
                        name: 'Project B',
                        data: [23, 33, 34, 40, 42]
                    }
                ]

                colors: ["#bd9925", "#2f71bd", "#720d3a", "#ef4917"],
                labels: ['Pending', 'In Progress', 'Completed', 'On Hold', 'Cancelled'],
                legend: {
                    show: true
                }
            };
            var chart = new ApexCharts(document.querySelector("#chart-doughnut"), options);
            chart.render();
        })();
    </script>
@endpush

@section('content')
    @php

        $project_task_percentage = 45;
        $label = '';
        if ($project_task_percentage <= 15) {
            $label = 'bg-danger';
        } elseif ($project_task_percentage > 15 && $project_task_percentage <= 33) {
            $label = 'bg-warning';
        } elseif ($project_task_percentage > 33 && $project_task_percentage <= 70) {
            $label = 'bg-primary';
        } else {
            $label = 'bg-primary';
        }

        $project_percentage = 70;
        $label1 = '';
        if ($project_percentage <= 15) {
            $label1 = 'bg-danger';
        } elseif ($project_percentage > 15 && $project_percentage <= 33) {
            $label1 = 'bg-warning';
        } elseif ($project_percentage > 33 && $project_percentage <= 70) {
            $label1 = 'bg-primary';
        } else {
            $label1 = 'bg-primary';
        }

        $project_bug_percentage = 25;
        $label2 = '';
        if ($project_bug_percentage <= 15) {
            $label2 = 'bg-danger';
        } elseif ($project_bug_percentage > 15 && $project_bug_percentage <= 33) {
            $label2 = 'bg-warning';
        } elseif ($project_bug_percentage > 33 && $project_bug_percentage <= 70) {
            $label2 = 'bg-primary';
        } else {
            $label2 = 'bg-primary';
        }
    @endphp

    <div class="row">
        @if (!empty($arrErr))
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if (!empty($arrErr['system']))
                    <div class="alert alert-danger text-xs">
                        {{ __('are required in') }} <a href="{{ route('settings') }}" class=""><u>
                                {{ __('System Setting') }}</u></a>
                    </div>
                @endif
                @if (!empty($arrErr['user']))
                    <div class="alert alert-danger text-xs">
                        <a href="{{ route('users') }}" class=""><u>{{ __('here') }}</u></a>
                    </div>
                @endif
                @if (!empty($arrErr['role']))
                    <div class="alert alert-danger text-xs">
                        <a href="{{ route('roles.index') }}" class=""><u>{{ __('here') }}</u></a>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <div class="col-sm-12">
        <div class="row">
            <div class="col-xxl-6">
                <div class="row">
                    @if (isset($arrCount['deal']))
                        <div class="col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-auto mb-3 mb-sm-0">
                                            <div class="d-flex align-items-center">
                                                <div class="theme-avtar bg-primary badge">
                                                    <i class="ti ti-cast"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <small class="text-muted">{{ __('Total') }}</small>
                                                    <h6 class="m-0"><a href="{{ route('deals.index') }}"
                                                            class="dashboard-link">{{ __('Deal') }}</a></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto text-end">
                                            <h5 class="m-0">{{ $arrCount['deal'] }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (isset($arrCount['task']))
                        <div class="col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-auto mb-3 mb-sm-0">
                                            <div class="d-flex align-items-center">
                                                <div class="theme-avtar bg-primary badge">
                                                    <i class="ti ti-list"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <small class="text-muted">{{ __('Total') }}</small>
                                                    <h6 class="m-0">{{ __('Deal Task') }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto text-end">
                                            <h5 class="m-0">{{ $arrCount['task'] }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Calendar') }}</h5>
                            </div>
                            <div class="card-body">
                                <div id='calendar' class='calendar'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6">
                <div class="row">
                    <div class="col--xxl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="align-items-start">
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{ __('Total Project') }}</p>
                                                <h3 class="mb-0 text-warning">10%%</h3>
                                                <div class="progress mb-0">
                                                    <div class="progress-bar bg-{{ $label1 }}"
                                                        style="width: {{ 100 }}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="align-items-start">
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{ __('Total Project Tasks') }}</p>
                                                <h3 class="mb-0 text-info">50%</h3>
                                                <div class="progress mb-0">
                                                    <div class="progress-bar bg-{{ $label1 }}"
                                                        style="width: {{ 30 }}}}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="align-items-start">

                                            <div class="ms-2">

                                                <p class="text-muted text-sm mb-0">{{ __('Total Bugs') }}</p>
                                                <h3 class="mb-0 text-danger">25%</h3>
                                                <div class="progress mb-0">
                                                    <div class="progress-bar bg-{{ $label1 }}"
                                                        style="width: {{ 30 }}%;"></div>
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
                                <h5>{{ __('Tasks Overview') }}</h5>
                                <h6 class="last-day-text">{{ __('Last 7 Days') }}</h6>
                            </div>
                            <div class="card-body">
                                <div id="chart-sales" height="200" class="p-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Project Status') }}
                                    <span class="float-end text-muted">{{ __('Year') }}</span>
                                </h5>

                            </div>
                            <div class="card-body">
                                <div id="chart-doughnut"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div
                class="{{ Auth::user()->type == 'company' || Auth::user()->type == 'client' ? 'col-xl-6 col-lg-6 col-md-6' : 'col-xl-8 col-lg-8 col-md-8' }} col-sm-12">
                <div class="card bg-none min-410 mx-410">
                    <div class="card-header">
                        <h5>{{ __('Top Due Project') }}</h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Task Name') }}</th>
                                        <th>{{ __('Remain Task') }}</th>
                                        <th>{{ __('Due Date') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @php
                                        $projects = [
                                            [
                                                'project_name' => 'Project Alpha',
                                                'due_date' => '2025-12-31',
                                                'end_date' => '2025-12-31',
                                                'total_task' => 20,
                                                'completed_task' => 10,
                                                'id' => 1,
                                            ],
                                            [
                                                'project_name' => 'Project Beta',
                                                'due_date' => '2025-10-15',
                                                'end_date' => '2025-10-15',
                                                'total_task' => 15,
                                                'completed_task' => 5,
                                                'id' => 2,
                                            ],
                                        ];
                                    @endphp

                                    @forelse($projects as $project)
                                        @php
                                            $datetime1 = new DateTime($project['due_date']);
                                            $datetime2 = new DateTime(date('Y-m-d'));
                                            $interval = $datetime1->diff($datetime2);
                                            $days = $interval->format('%a');

                                            $project_last_stage = 'Stage 3'; // Static value
                                            $total_task = $project['total_task'];
                                            $completed_task = $project['completed_task'];
                                            $remain_task = $total_task - $completed_task;
                                        @endphp
                                        <tr>
                                            <td class="id-web">
                                                {{ $project['project_name'] }}
                                            </td>
                                            <td>{{ $remain_task }}</td>
                                            <td>{{ date('Y-m-d', strtotime($project['end_date'])) }}</td>
                                            <td>
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="4">{{ __('No Data Found.!') }}</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6">
                <div class="card bg-none min-410 mx-410">
                    <div class="card-header">
                        <h5>{{ __('Top Due Task') }}</h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Task Name') }}</th>
                                        <th>{{ __('Assign To') }}</th>
                                        <th>{{ __('Task Stage') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $top_tasks = [
                                            [
                                                'name' => 'Design Homepage',
                                                'users' => [
                                                    ['name' => 'Alice', 'avatar' => 'avatar-1.png'],
                                                    ['name' => 'Bob', 'avatar' => 'avatar-2.png'],
                                                    ['name' => 'Charlie', 'avatar' => 'avatar-3.png'],
                                                    ['name' => 'Dave', 'avatar' => 'avatar-4.png'],
                                                ],
                                                'stage' => 'In Progress',
                                            ],
                                            [
                                                'name' => 'Create API Endpoints',
                                                'users' => [
                                                    ['name' => 'Eve', 'avatar' => 'avatar-5.png'],
                                                    ['name' => 'Frank', 'avatar' => 'avatar-6.png'],
                                                ],
                                                'stage' => 'Completed',
                                            ],
                                        ];
                                    @endphp

                                    @forelse($top_tasks as $top_task)
                                        <tr>
                                            <td class="id-web">
                                                {{ $top_task['name'] }}
                                            </td>
                                            <td>
                                                <div class="avatar-group">
                                                    @if (count($top_task['users']) > 0)
                                                        @foreach ($top_task['users'] as $key => $user)
                                                            @if ($key < 3)
                                                                <a href="#" class="avatar rounded-circle avatar-sm">
                                                                    <img data-original-title="{{ $user['name'] }}"
                                                                        src="{{ asset('assets/img/avatar/' . $user['avatar']) }}"
                                                                        title="{{ $user['name'] }}" class="hweb">
                                                                </a>
                                                            @else
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @if (count($top_task['users']) > 3)
                                                            <a href="#" class="avatar rounded-circle avatar-sm">
                                                                <img data-original-title="{{ $top_task['users'][3]['name'] }}"
                                                                    src="{{ asset('assets/img/avatar/' . $top_task['users'][3]['avatar']) }}"
                                                                    class="hweb">
                                                            </a>
                                                        @endif
                                                    @else
                                                        {{ __('-') }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="p-2 px-3 rounded badge bg-primary">{{ $top_task['stage'] }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="4">{{ __('No Data Found.!') }}</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
