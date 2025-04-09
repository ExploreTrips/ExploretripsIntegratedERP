<?php

namespace App\Http\Controllers;

use App\Models\Utility;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function __construct(){

    }

    public function changeLanguage($lang){
        $user = Auth::user();
        $user->update(['lang'=>$lang]);
        $value = in_array($lang,['ar','he'])?'on':'off';
        if($user->type === 'super admin'){
            Settings::UpdateorCreate(
                ['name' => 'SITE_RTL', 'created_by' => $user->creatorId()],
                ['value' => $value]
            );
        };
        return redirect()->back()->with('success', __('Language changed successfully.'));
    }
}
