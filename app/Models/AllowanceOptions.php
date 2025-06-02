<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllowanceOptions extends Model
{
    protected $table = 'allowance_options';

    protected $fillable = [
        'name',
        'created_by',
    ];
}
