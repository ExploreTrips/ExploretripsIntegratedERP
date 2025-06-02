<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayslipTypes extends Model
{
    protected $table = 'payslip_types';

    protected $fillable = [
        'name',
        'created_by',
    ];

}
