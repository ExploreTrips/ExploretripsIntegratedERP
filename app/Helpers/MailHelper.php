<?php

namespace App\Helpers;

use App\Models\Utility;
use App\Models\EmailTemplate;
use App\Mail\CommonEmailTemplate;
use App\Models\EmailTemplateLang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function sendEmailTemplate($emailTemplate, $mailTo, $obj)
    {
        $usr = Auth::user();
        $mailTo = array_values($mailTo);
        if ($usr->type != 'Super Admin') {
            $template = EmailTemplate::where('name', 'LIKE', $emailTemplate)->first();
            if ($template) {
                $is_active = $usr->type != 'super admin'
                    ? UserEmailTemplate::where('template_id', $template->id)->where('user_id', $usr->creatorId())->first()
                    : (object)['is_active' => 1];
                if ($is_active->is_active == 1) {
                    $settings = Utility::settingsById($usr->id);
                    $data = Utility::getSetting();
                    $setting = [
                        'mail_driver' => '',
                        'mail_host' => '',
                        'mail_port' => '',
                        'mail_encryption' => '',
                        'mail_username' => '',
                        'mail_password' => '',
                        'mail_from_address' => '',
                        'mail_from_name' => '',
                    ];
                    foreach ($data as $row) {
                        $setting[$row->name] = $row->value;
                    }

                    $content = EmailTemplateLang::where('parent_id', $template->id)->where('lang', $usr->lang)->first();
                    print_r($content);die;
                    $content->from = $template->from;
                    if (!empty($content->content)) {
                        $content->content = Utility::replaceVariable($content->content, $obj);

                        try {
                            config([
                                'mail.driver' => $settings['mail_driver'] ?? $setting['mail_driver'],
                                'mail.host' => $settings['mail_host'] ?? $setting['mail_host'],
                                'mail.port' => $settings['mail_port'] ?? $setting['mail_port'],
                                'mail.encryption' => $settings['mail_encryption'] ?? $setting['mail_encryption'],
                                'mail.username' => $settings['mail_username'] ?? $setting['mail_username'],
                                'mail.password' => $settings['mail_password'] ?? $setting['mail_password'],
                                'mail.from.address' => $settings['mail_from_address'] ?? $setting['mail_from_address'],
                                'mail.from.name' => $settings['mail_from_name'] ?? $setting['mail_from_name'],
                            ]);

                            Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));

                            return ['is_success' => true, 'error' => false];
                        } catch (\Exception $e) {
                            return ['is_success' => false, 'error' => 'Mail not sent!'];
                        }
                    } else {
                        return ['is_success' => false, 'error' => __('Mail not sent, email is empty')];
                    }
                }

                return ['is_success' => true, 'error' => false];
            }
            return ['is_success' => false, 'error' => __('Mail not sent, template not found')];
        }
    }
}
