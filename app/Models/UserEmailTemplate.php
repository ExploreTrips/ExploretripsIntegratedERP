<?php

namespace App\Models;

use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserEmailTemplate extends Model
{
    use HasFactory;

    protected $table = 'user_email_templates'; // Explicitly specify table name for clarity

    protected $fillable = [
        'template_id',
        'user_id',
        'is_active',
    ];

    /**
     * Relationship with EmailTemplate
     */
    public function emailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
