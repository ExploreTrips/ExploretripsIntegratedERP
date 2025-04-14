<?php

namespace App\Http\Controllers\Settings;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsContrpller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\Auth::user()->can('manage system settings')) {
            $settings = Utility::settings();
            // $admin_payment_setting = Utility::getAdminPaymentSetting();
            // // $emailSetting = Utility::settingsById(\Auth::user()->id);
            // $file_size = 0;
            // foreach (\File::allFiles(storage_path('/framework')) as $file) {
            //     $file_size += $file->getSize();
            // }
            // $file_size = number_format($file_size / 1000000, 4);
            return view('settings.index',compact('settings'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {

    //     if (\Auth::user()->can('manage system settings')) {
    //         if ($request->logo_dark) {
    //             $logoName = 'logo-dark.png';
    //             $dir = 'uploads/logo/';
    //             $validation = [
    //                 'mimes:' . 'png',
    //                 'max:' . '20480',
    //             ];
    //             $path = Utility::upload_file($request, 'logo_dark', $logoName, $dir, $validation);
    //             if ($path['flag'] == 1) {
    //                 $logo = $path['url'];
    //             } else {
    //                 return redirect()->back()->with('error', __($path['msg']));
    //             }
    //         }

    //         if ($request->logo_light) {

    //             $logoName = 'logo-light.png';

    //             $dir = 'uploads/logo';
    //             $validation = [
    //                 'mimes:' . 'png',
    //                 'max:' . '20480',
    //             ];
    //             $path = Utility::upload_file($request, 'logo_light', $logoName, $dir, $validation);
    //             if ($path['flag'] == 1) {
    //                 $logo = $path['url'];
    //             } else {
    //                 return redirect()->back()->with('error', __($path['msg']));
    //             }
    //         }

    //         if ($request->favicon) {

    //             $favicon = 'favicon.png';
    //             $dir = 'uploads/logo';
    //             $validation = [
    //                 'mimes:' . 'png',
    //                 'max:' . '20480',
    //             ];

    //             $path = Utility::upload_file($request, 'favicon', $favicon, $dir, $validation);
    //             if ($path['flag'] == 1) {
    //                 $favicon = $path['url'];
    //             } else {
    //                 return redirect()->back()->with('error', __($path['msg']));
    //             }
    //         }

    //         $settings = Utility::settings();

    //         if (
    //             !empty($request->title_text) || !empty($request->color) || !empty($request->SITE_RTL)
    //             || !empty($request->footer_text) || !empty($request->default_language) || isset($request->display_landing_page)
    //             || isset($request->gdpr_cookie) || isset($request->enable_signup) || isset($request->email_verification)
    //             || isset($request->color) || !empty($request->cust_theme_bg) || !empty($request->cust_darklayout)
    //         ) {
    //             $post = $request->all();

    //             $SITE_RTL = $request->has('SITE_RTL') ? $request->SITE_RTL : 'off';
    //             $post['SITE_RTL'] = $SITE_RTL;

    //             if (isset($request->color) && $request->color_flag == 'false') {
    //                 $post['color'] = $request->color;
    //             } else {
    //                 $post['color'] = $request->custom_color;
    //             }

    //             if (!isset($request->display_landing_page)) {
    //                 $post['display_landing_page'] = 'off';
    //             }
    //             if (!isset($request->gdpr_cookie)) {
    //                 $post['gdpr_cookie'] = 'off';
    //             }
    //             if (!isset($request->enable_signup)) {
    //                 $post['enable_signup'] = 'off';
    //             }
    //             if (!isset($request->email_verification)) {
    //                 $post['email_verification'] = 'off';
    //             }


    //             if (!isset($request->cust_theme_bg)) {
    //                 $cust_theme_bg = (!empty($request->cust_theme_bg)) ? 'on' : 'off';
    //                 $post['cust_theme_bg'] = $cust_theme_bg;
    //             }
    //             if (!isset($request->cust_darklayout)) {

    //                 $cust_darklayout = (!empty($request->cust_darklayout)) ? 'on' : 'off';
    //                 $post['cust_darklayout'] = $cust_darklayout;
    //             }

    //             unset($post['_token'], $post['company_logo_dark'], $post['company_logo_light'], $post['company_favicon'], $post['custom_color']);

    //             foreach ($post as $key => $data) {
    //                 if (in_array($key, array_keys($settings))) {
    //                     \DB::insert(
    //                         'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
    //                         [
    //                             $data,
    //                             $key,
    //                             \Auth::user()->creatorId(),
    //                         ]
    //                     );
    //                 }
    //             }
    //         }

    //         return redirect()->back()->with('success', 'Brand Setting successfully updated.');
    //     } else {
    //         return redirect()->back()->with('error', 'Permission denied.');
    //     }
    // }


    public function store(Request $request)
{
    if (\Auth::user()->can('manage system settings')) {
        if ($request->logo_dark) {
            $logoName = 'logo-dark.png';
            $dir = 'uploads/logo'; // New path inside storage/app/public
            $validation = [
                'mimes:' . 'png',
                'max:' . '20480',
            ];

            // Ensure it stores the file in public storage
            $path = $request->file('logo_dark')->storeAs('public/' . $dir, $logoName);

            // If path is saved successfully
            if ($path) {
                // Store the public path
                $logo = 'storage/' . $dir . '/' . $logoName;
            } else {
                return redirect()->back()->with('error', 'Failed to upload logo.');
            }
        }

        if ($request->logo_light) {
            $logoName = 'logo-light.png';
            $dir = 'uploads/logo';
            $validation = [
                'mimes:' . 'png',
                'max:' . '20480',
            ];

            // Store file in public storage
            $path = $request->file('logo_light')->storeAs('public/' . $dir, $logoName);

            if ($path) {
                $logo = 'storage/' . $dir . '/' . $logoName;
            } else {
                return redirect()->back()->with('error', 'Failed to upload light logo.');
            }
        }

        if ($request->favicon) {
            $favicon = 'favicon.png';
            $dir = 'uploads/logo';
            $validation = [
                'mimes:' . 'png',
                'max:' . '20480',
            ];

            // Store favicon in public storage
            $path = $request->file('favicon')->storeAs('public/' . $dir, $favicon);

            if ($path) {
                $favicon = 'storage/' . $dir . '/' . $favicon;
            } else {
                return redirect()->back()->with('error', 'Failed to upload favicon.');
            }
        }

        $settings = Utility::settings();

        if (
            !empty($request->title_text) || !empty($request->color) || !empty($request->SITE_RTL)
            || !empty($request->footer_text) || !empty($request->default_language) || isset($request->display_landing_page)
            || isset($request->gdpr_cookie) || isset($request->enable_signup) || isset($request->email_verification)
            || isset($request->color) || !empty($request->cust_theme_bg) || !empty($request->cust_darklayout)
        ) {
            $post = $request->all();

            $SITE_RTL = $request->has('SITE_RTL') ? $request->SITE_RTL : 'off';
            $post['SITE_RTL'] = $SITE_RTL;

            if (isset($request->color) && $request->color_flag == 'false') {
                $post['color'] = $request->color;
            } else {
                $post['color'] = $request->custom_color;
            }

            if (!isset($request->display_landing_page)) {
                $post['display_landing_page'] = 'off';
            }
            if (!isset($request->gdpr_cookie)) {
                $post['gdpr_cookie'] = 'off';
            }
            if (!isset($request->enable_signup)) {
                $post['enable_signup'] = 'off';
            }
            if (!isset($request->email_verification)) {
                $post['email_verification'] = 'off';
            }

            if (!isset($request->cust_theme_bg)) {
                $cust_theme_bg = (!empty($request->cust_theme_bg)) ? 'on' : 'off';
                $post['cust_theme_bg'] = $cust_theme_bg;
            }
            if (!isset($request->cust_darklayout)) {
                $cust_darklayout = (!empty($request->cust_darklayout)) ? 'on' : 'off';
                $post['cust_darklayout'] = $cust_darklayout;
            }

            unset($post['_token'], $post['company_logo_dark'], $post['company_logo_light'], $post['company_favicon'], $post['custom_color']);

            foreach ($post as $key => $data) {
                if (in_array($key, array_keys($settings))) {
                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                        [
                            $data,
                            $key,
                            \Auth::user()->creatorId(),
                        ]
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Brand Setting successfully updated.');
    } else {
        return redirect()->back()->with('error', 'Permission denied.');
    }
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
