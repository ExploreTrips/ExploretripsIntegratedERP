<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function account_dashboard_index()
    {
        if (Auth::check()) {
            if (Auth::user()->type == 'super admin') {
                return redirect()->route('client.dashboard.view');
            } elseif (Auth::user()->type == 'client') {
                return redirect()->route('client.dashboard.view');
            } else {
                if (\Auth::user()->can('show account dashboard')) {
                    // $data['latestIncome'] = Revenue::with(['customer'])->where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->get();
                    // $data['latestExpense'] = Payment::with(['vender'])->where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->get();
                    $currentYer = date('Y');

                    // $incomeCategory = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())
                    //     ->where('type', '=', 'income')->get();

                    // $inColor = array();
                    // $inCategory = array();
                    // $inAmount = array();
                    // for ($i = 0; $i < count($incomeCategory); $i++) {
                    //     $inColor[] = '#' . $incomeCategory[$i]->color;
                    //     $inCategory[] = $incomeCategory[$i]->name;
                    //     $inAmount[] = $incomeCategory[$i]->incomeCategoryRevenueAmount();
                    // }

                    // $data['incomeCategoryColor'] = $inColor;
                    // $data['incomeCategory'] = $inCategory;
                    // $data['incomeCatAmount'] = $inAmount;

                    // $expenseCategory = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())
                    //     ->where('type', '=', 'expense')->get();
                    // $exColor = array();
                    // $exCategory = array();
                    // $exAmount = array();
                    // for ($i = 0; $i < count($expenseCategory); $i++) {
                    //     $exColor[] = '#' . $expenseCategory[$i]->color;
                    //     $exCategory[] = $expenseCategory[$i]->name;
                    //     $exAmount[] = $expenseCategory[$i]->expenseCategoryAmount();
                    // }

                    // $data['expenseCategoryColor'] = $exColor;
                    // $data['expenseCategory'] = $exCategory;
                    // $data['expenseCatAmount'] = $exAmount;

                    // $data['incExpBarChartData'] = \Auth::user()->getincExpBarChartData();
                    // //                dd( $data['incExpBarChartData']);
                    // $data['incExpLineChartData'] = \Auth::user()->getIncExpLineChartDate();

                    // $data['currentYear'] = date('Y');
                    // $data['currentMonth'] = date('M');

                    // $constant['taxes'] = Tax::where('created_by', \Auth::user()->creatorId())->count();
                    // $constant['category'] = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->count();
                    // $constant['units'] = ProductServiceUnit::where('created_by', \Auth::user()->creatorId())->count();
                    // $constant['bankAccount'] = BankAccount::where('created_by', \Auth::user()->creatorId())->count();
                    // $data['constant'] = $constant;
                    // $data['bankAccountDetail'] = BankAccount::where('created_by', '=', \Auth::user()->creatorId())->get();
                    // $data['recentInvoice'] = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
                    //     ->where('invoices.created_by', '=', \Auth::user()->creatorId())
                    //     ->orderBy('invoices.id', 'desc')
                    //     ->limit(5)
                    //     ->select('invoices.*', 'customers.name as customer_name')
                    //     ->get();

                    // $data['weeklyInvoice'] = \Auth::user()->weeklyInvoice();
                    // $data['monthlyInvoice'] = \Auth::user()->monthlyInvoice();
                    // $data['recentBill'] = Bill::join('venders', 'bills.vender_id', '=', 'venders.id')
                    // ->where('bills.created_by', '=', \Auth::user()->creatorId())
                    // ->orderBy('bills.id', 'desc')
                    // ->limit(5)
                    // ->select('bills.*', 'venders.name as vender_name')
                    // ->get();

                    // $data['weeklyBill'] = \Auth::user()->weeklyBill();
                    // $data['monthlyBill'] = \Auth::user()->monthlyBill();
                    // $data['goals'] = Goal::where('created_by', '=', \Auth::user()->creatorId())->where('is_display', 1)->get();

                    //Storage limit
                    $data['users'] = User::find(\Auth::user()->creatorId());
                    $data['plan'] = Plan::getPlan(\Auth::user()->show_dashboard());
                    if ($data['plan']->storage_limit > 0) {
                        $data['storage_limit'] = ($data['users']->storage_limit / $data['plan']->storage_limit) * 100;
                    } else {
                        $data['storage_limit'] = 0;
                    }

                    // dd($data);
                    return view('dashboard.account-dashboard', $data);
                } else {

                    return $this->hrm_dashboard_index();
                }

            }
        } else {
                return redirect('login');

            }
        }


        public function clientView()
        {
            if (Auth::check()) {
                if (Auth::user()->type == 'super admin') {
                    $user = \Auth::user();
                    $user['total_user'] = $user->countCompany();
                    $user['total_paid_user'] = $user->countPaidCompany();

                    return view('dashboard.super_admin', compact('user'));

                } elseif (Auth::user()->type == 'client') {
                    $transdate = date('Y-m-d', time());
                    $currentYear = date('Y');

                    $calenderTasks = [];
                    $chartData = [];
                    $arrCount = [];
                    $arrErr = [];
                    $m = date("m");
                    $de = date("d");
                    $y = date("Y");
                    $format = 'Y-m-d';
                    $user = \Auth::user();
                    if (\Auth::user()->can('View Task')) {
                        $company_setting = Utility::settings();
                    }
                    $arrTemp = [];
                    for ($i = 0; $i <= 7 - 1; $i++) {
                        $date = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));
                        $arrTemp['date'][] = __(date('D', strtotime($date)));
                        $arrTemp['invoice'][] = 10;
                        $arrTemp['payment'][] = 20;
                    }
                    $chartData = $arrTemp;

                    // foreach ($user->clientDeals as $deal) {
                    //     foreach ($deal->tasks as $task) {
                    //         $calenderTasks[] = [
                    //             'title' => $task->name,
                    //             'start' => $task->date,
                    //             'url' => route('deals.tasks.show', [
                    //                 $deal->id,
                    //                 $task->id,
                    //             ]),
                    //             'className' => ($task->status) ? 'bg-primary border-primary' : 'bg-warning border-warning',
                    //         ];
                    //     }

                    //     $calenderTasks[] = [
                    //         'title' => $deal->name,
                    //         'start' => $deal->created_at->format('Y-m-d'),
                    //         'url' => route('deals.show', [$deal->id]),
                    //         'className' => 'deal bg-primary border-primary',
                    //     ];
                    // }
                    // $client_deal = $user->clientDeals->pluck('id');

                    // $arrCount['deal'] = !empty($user->clientDeals) ? $user->clientDeals->count() : 0;
                    return view('dashboard.clientView');
                }
            }
        }


        public function hrm_dashboard_index()
        {
            if (Auth::check()) {
                if (\Auth::user()->can('show hrm dashboard')) {
                    $user = Auth::user();
                    if ($user->type != 'client' && $user->type != 'company') {
                        // $emp = Employee::where('user_id', '=', $user->id)->first();
                        // $announcements = Announcement::orderBy('announcements.id', 'desc')->take(5)->leftjoin('announcement_employees', 'announcements.id', '=', 'announcement_employees.announcement_id')->where('announcement_employees.employee_id', '=', $emp->id)->orWhere(function ($q) {
                        //     $q->where('announcements.department_id', '["0"]')->where('announcements.employee_id', '["0"]');
                        // })->get();

                        // $employees = Employee::get();
                        // $meetings = Meeting::orderBy('meetings.id', 'desc')->take(5)->leftjoin('meeting_employees', 'meetings.id', '=', 'meeting_employees.meeting_id')->where('meeting_employees.employee_id', '=', $emp->id)->orWhere(function ($q) {
                        //     $q->where('meetings.department_id', '["0"]')->where('meetings.employee_id', '["0"]');
                        // })->get();
                        // $events = Event::leftjoin('event_employees', 'events.id', '=', 'event_employees.event_id')->where('event_employees.employee_id', '=', $emp->id)->orWhere(function ($q) {
                        //     $q->where('events.department_id', '["0"]')->where('events.employee_id', '["0"]');
                        // })->get();

                        // $arrEvents = [];
                        // foreach ($events as $event) {

                        //     $arr['id'] = $event['id'];
                        //     $arr['title'] = $event['title'];
                        //     $arr['start'] = $event['start_date'];
                        //     $arr['end'] = $event['end_date'];
                        //     $arr['backgroundColor'] = $event['color'];
                        //     $arr['borderColor'] = "#fff";
                        //     $arr['textColor'] = "white";
                        //     $arrEvents[] = $arr;
                        // }

                        // $date = date("Y-m-d");
                        // $time = date("H:i:s");
                        // $employeeAttendance = AttendanceEmployee::orderBy('id', 'desc')->where('employee_id', '=', !empty(\Auth::user()->employee)?\Auth::user()->employee->id : 0)->where('date', '=', $date)->first();

                        // $officeTime['startTime'] = Utility::getValByName('company_start_time');
                        // $officeTime['endTime'] = Utility::getValByName('company_end_time');

                        return view('dashboard.dashboard');
                    } else if ($user->type == 'super admin') {
                        $user = \Auth::user();
                        $user['total_user'] = $user->countCompany();
                        $user['total_paid_user'] = $user->countPaidCompany();
                        // $user['total_orders'] = Order::total_orders();
                        // $user['total_orders_price'] = Order::total_orders_price();
                        $user['total_plan'] = Plan::total_plan();
                        if(!empty(Plan::most_purchese_plan()))
                        {
                            $plan = Plan::find(Plan::most_purchese_plan()['plan']);
                            $user['most_purchese_plan'] = $plan->name;
                        }
                        else
                        {
                            $user['most_purchese_plan'] = '-';
                        }
                        // $chartData = $this->getOrderChart(['duration' => 'week']);
                        return view('dashboard.super_admin', compact('user'));
                    } else {
                        // $events = Event::where('created_by', '=', \Auth::user()->creatorId())->get();
                        // $arrEvents = [];

                        // foreach ($events as $event) {
                        //     $arr['id'] = $event['id'];
                        //     $arr['title'] = $event['title'];
                        //     $arr['start'] = $event['start_date'];
                        //     $arr['end'] = $event['end_date'];

                        //     $arr['backgroundColor'] = $event['color'];
                        //     $arr['borderColor'] = "#fff";
                        //     $arr['textColor'] = "white";
                        //     $arr['url'] = route('event.edit', $event['id']);

                        //     $arrEvents[] = $arr;
                        // }

                        // $announcements = Announcement::orderBy('announcements.id', 'desc')->take(5)->where('created_by', '=', \Auth::user()->creatorId())->get();

                        // // $emp           = User::where('type', '!=', 'client')->where('type', '!=', 'company')->where('created_by', '=', \Auth::user()->creatorId())->get();
                        // // $countEmployee = count($emp);

                        // $user = User::where('type', '!=', 'client')->where('type', '!=', 'company')->where('created_by', '=', \Auth::user()->creatorId())->get();
                        // $countUser = count($user);

                        // $countTrainer = Trainer::where('created_by', '=', \Auth::user()->creatorId())->count();
                        // $onGoingTraining = Training::where('status', '=', 1)->where('created_by', '=', \Auth::user()->creatorId())->count();
                        // $doneTraining = Training::where('status', '=', 2)->where('created_by', '=', \Auth::user()->creatorId())->count();

                        // $currentDate = date('Y-m-d');

                        // $employees = User::where('type', '=', 'client')->where('created_by', '=', \Auth::user()->creatorId())->get();
                        // $countClient = count($employees);
                        // $notClockIn = AttendanceEmployee::where('date', '=', $currentDate)->get()->pluck('employee_id');

                        // $notClockIns = Employee::where('created_by', '=', \Auth::user()->creatorId())->whereNotIn('id', $notClockIn)->get();
                        // $activeJob = Job::where('status', 'active')->where('created_by', '=', \Auth::user()->creatorId())->count();
                        // $inActiveJOb = Job::where('status', 'in_active')->where('created_by', '=', \Auth::user()->creatorId())->count();

                        // $meetings = Meeting::where('created_by', '=', \Auth::user()->creatorId())->limit(5)->get();

                        return view('dashboard.dashboard');
                    }
                } else {

                    return $this->project_dashboard_index();
                }
            }
    }


    public function project_dashboard_index()
    {
        $user = Auth::user();

        if (\Auth::user()->can('show project dashboard')) {
            if ($user->type == 'admin') {
                return view('admin.dashboard');
            } else {
                $home_data = [];
                        //    dd($user->projects());
                        return view('dashboard.project-dashboard', compact('home_data'));
            }
        } else {
            return $this->account_dashboard_index();
        }
    }



}
