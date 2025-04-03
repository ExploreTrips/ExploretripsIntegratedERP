<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginDetail extends Model
{
    use HasFactory;
    protected $table = 'login_details';
    protected $fillable = [
        'user_id',
        'ip',
        'date',
        'details', // Corrected 'Details' to lowercase to match migration
        'created_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
