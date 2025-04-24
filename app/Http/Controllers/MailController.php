<?php

namespace App\Http\Controllers;

use App\Models\Utility;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateLang;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    public function manageEmailLang($id, $lang = 'en')
    {
        if (Auth::user()->type !== 'super admin') {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        $languages         = Utility::languages();
        $LangName = Language::where('code',$lang)->first();
        $emailTemplate     = EmailTemplate::emailTemplateData();
        if (!$emailTemplate) {
            return redirect()->back()->with('error', 'Data not found.');
        }
        $currEmailTempLang = EmailTemplateLang::where('parent_id', '=', $id)->where('lang', $lang)->first();
        if(!isset($currEmailTempLang) || empty($currEmailTempLang))
        {
            $currEmailTempLang = EmailTemplateLang::where('lang', $lang)->first();
            $currEmailTempLang->lang = $lang;
        }
        $EmailTemplates = EmailTemplate::all();
        return view('email_templates.show', compact('emailTemplate', 'languages', 'currEmailTempLang','EmailTemplates','LangName'));

        }
    }




