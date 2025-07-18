<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table = 'email_templates';
    protected $fillable = [
        'name',
        'from',
        'slug',
        'created_by',
    ];

    public function template()
    {
    return $this->hasOne(UserEmailTemplate::class, 'template_id', 'id')
                ->where('user_id', Auth::id());
    }

    private static ?EmailTemplate $templateData = null;

    public static function emailTemplateData(): ?EmailTemplate
    {
        return self::$templateData ??= EmailTemplate::first();
    }

}
