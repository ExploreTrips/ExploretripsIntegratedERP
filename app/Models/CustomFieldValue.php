<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFieldValue extends Model
{
    protected $table = 'custom_field_values';
    protected $fillable = [
        'record_id',
        'field_id',
        'value',
    ];
}
