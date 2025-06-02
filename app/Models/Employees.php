<?php

namespace App\Models;

use App\Models\User;
use App\Models\Branch;
use App\Models\Documents;
use App\Models\Allowances;
use App\Models\Department;
use App\Models\Designation;
use App\Models\EmployeeDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employees extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = [
        'user_id',
        'branch_id',
        'department_id',
        'designation_id',
        'name',
        'dob',
        'gender',
        'phone',
        'address',
        'email',
        'password',
        'employee_id',
        'company_doj',
        'documents',
        'account_holder_name',
        'account_number',
        'bank_name',
        'bank_ifsc_code',
        'branch_location',
        'tax_payer_id',
        'salary_type',
        'salary',
        'is_active',
        'created_by',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function documents()
    {
        $documents= $this->hasMany(EmployeeDocument::class, 'employee_id', 'id');
        // echo($documents);die;
        return $documents;
    }

    public function salaryType()
    {
        $salrytypes = $this->belongsTo('App\Models\PayslipTypes', 'salary_type', 'id');
        // echo $salrytypes;die;
        return $salrytypes;
    }

    public function allowances()
    {
        return $this->hasMany(Allowances::class,'employee_id');
    }

    public function get_net_salary()
    {
        // Calculate total allowances
        $totalAllowance = $this->allowances->sum(function ($item) {
            return $item->type === 'fixed'
                ? $item->amount
                : ($item->amount * $this->salary / 100);
        });
        // Calculate total commissions
        // $totalCommission = $this->commissions->sum(function ($item) {
        //     return $item->type === 'fixed'
        //         ? $item->amount
        //         : ($item->amount * $this->salary / 100);
        // });
        // // Calculate total loans
        // $totalLoan = $this->loans->sum(function ($item) {
        //     return $item->type === 'fixed'
        //         ? $item->amount
        //         : ($item->amount * $this->salary / 100);
        // });
        // // Calculate total saturation deductions
        // $totalDeduction = $this->saturationDeductions->sum(function ($item) {
        //     return $item->type === 'fixed'
        //         ? $item->amount
        //         : ($item->amount * $this->salary / 100);
        // });
        // // Calculate total other payments
        // $totalOtherPayment = $this->otherPayments->sum(function ($item) {
        //     return $item->type === 'fixed'
        //         ? $item->amount
        //         : ($item->amount * $this->salary / 100);
        // });
        // // Calculate total overtime
        // $totalOvertime = $this->overtimes->sum(function ($item) {
        //     return $item->number_of_days * $item->hours * $item->rate;
        // });

        // Final net salary calculation
        $netSalary = $this->salary
            + $totalAllowance;
            // + $totalCommission
            // + $totalOtherPayment
            // + $totalOvertime
            // - $totalLoan
            // - $totalDeduction;

        return $netSalary;
    }



}
