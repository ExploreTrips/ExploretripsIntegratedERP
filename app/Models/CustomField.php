<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $table = 'custom_fields';
    protected $fillable = [
        'name',
        'type',
        'module',
        'created_by',
    ];

    public static $fieldTypes = [
        'text' => 'Text',
        'email' => 'Email',
        'number' => 'Number',
        'date' => 'Date',
        'textarea' => 'Textarea',
    ];

    public static $modules = [
        'user' => 'User',
        'customer' => 'Customer',
        'vendor' => 'Vendor',
        'product' => 'Product',
        'proposal' => 'Proposal',
        'Invoice' => 'Invoice',
        'Bill' => 'Bill',
        'account' => 'Account',
    ];

}
