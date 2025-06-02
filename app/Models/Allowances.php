<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allowances extends Model
{
    protected $table = 'allowances';
     protected $fillable = [
        'employee_id',
        'allowance_option',
        'title',
        'amount',
        'created_by',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employees', 'employee_id');
    }

    public function allowanceOption()
    {
        return $this->belongsTo('App\Models\AllowanceOptions', 'allowance_option');
    }

    public static $Allowancetype =[
        'fixed'      => 'Fixed',
        'percentage' => 'Percentage',
    ];


}
