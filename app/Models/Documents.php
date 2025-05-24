<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documents extends Model
{
    use HasFactory;
    protected $tbale = 'documents';
    protected $fillable = [
        'name',
        'is_required',
        'created_by',
    ];
}
