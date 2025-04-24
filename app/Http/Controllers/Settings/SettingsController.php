<?php

namespace App\Http\Controllers\Settings;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
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
    public function store(Request $request)
    {

        if (Auth::user()->can('manage system settings')) {
            if ($request->hasFile('logo_dark')) {
                $logoName = 'logo-dark.png';
                $dir = 'uploads/logo';

                $validation = [
                    'logo_dark' => 'mimes:png|max:20480',
                ];

                $request->validate($validation);

                $path = $request->file('logo_dark')->storeAs($dir, $logoName, 'public');

                if ($path) {
                    $logo = 'storage/' . $path;
                } else {
                    return redirect()->back()->with('error', 'Failed to upload logo.');
                }
            }


            if ($request->hasFile('logo_light')) {
                $logoName = 'logo-light.png';
                $dir = 'uploads/logo';

                $validation = [
                    'logo_light' => 'mimes:png|max:20480',
                ];

                $request->validate($validation);

                $path = $request->file('logo_light')->storeAs($dir, $logoName, 'public');

                if ($path) {
                    $logo = 'storage/' . $path;
                } else {
                    return redirect()->back()->with('error', 'Failed to upload logo.');
                }
            }

            if ($request->hasFile('favicon')) {
                $favicon = 'favicon.png';
                $dir = 'uploads/logo';

                $validation = [
                    'logo_light' => 'mimes:png|max:20480',
                ];

                $request->validate($validation);

                $path = $request->file('favicon')->storeAs($dir, $favicon, 'public');

                if ($path) {
                    $logo = 'storage/' . $path;
                } else {
                    return redirect()->back()->with('error', 'Failed to upload logo.');
                }
            }
            $settings = Utility::settings();
            if (
                !empty($request->title_text) || !empty($request->color) || !empty($request->SITE_RTL)
                || !empty($request->footer_text) || !empty($request->default_language) || isset($request->enable_signup) || isset($request->email_verification)
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
                $userId = Auth::user()->creatorId();
                foreach ($post as $key => $data) {
                    if(array_key_exists($key,$settings)){
                        DB::table('settings')->updateOrInsert(
                            [
                                'name' => $key,
                                'created_by' => $userId
                            ],
                            [
                                'value' => $data
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

    public function saveEmailSettings(Request $request)
    {
        if (!\Auth::user()->can('manage system settings')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        $request->validate([
            'mail_driver'       => 'required|string|max:255',
            'mail_host'         => 'required|string|max:255',
            'mail_port'         => 'required|numeric',
            'mail_username'     => 'required|string|max:255',
            'mail_password'     => 'required|string|max:255',
            'mail_encryption'   => 'required|string|max:255',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name'    => 'required|string|max:255',
        ]);
        $post = $request->except('_token');
        $settings = Utility::settings();
        $userId = \Auth::user()->creatorId();
        foreach ($post as $key => $value) {
            if (array_key_exists($key, $settings)) {
                \DB::table('settings')->updateOrInsert(
                    ['name' => $key, 'created_by' => $userId],
                    ['value' => $value]
                );
            }
        }
        return redirect()->back()->with('success', __('Setting successfully updated.'));
    }

    public function mailTest(Request $request)
    {
        $data = $request->only([
            'mail_driver',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
        ]);
        return view('settings.test_mail', compact('data'));
    }


    // public function testSendMail(Request $request)
    // {

    //     $validator = \Validator::make(
    //         $request->all(),
    //         [
    //             'email' => 'required|email',
    //             'mail_driver' => 'required',
    //             'mail_host' => 'required',
    //             'mail_port' => 'required',
    //             'mail_username' => 'required',
    //             'mail_password' => 'required',
    //             'mail_from_address' => 'required',
    //             'mail_from_name' => 'required',
    //         ]
    //     );
    //     if ($validator->fails()) {
    //         $messages = $validator->getMessageBag();
    //         return response()->json(
    //             [
    //                 'is_success' => false,
    //                 'message' => $messages->first(),
    //             ]
    //         );
    //         // return redirect()->back()->with('error', $messages->first());
    //     }

    //     try {
    //         config(
    //             [
    //                 'mail.driver' => $request->mail_driver,
    //                 'mail.host' => $request->mail_host,
    //                 'mail.port' => $request->mail_port,
    //                 'mail.encryption' => $request->mail_encryption,
    //                 'mail.username' => $request->mail_username,
    //                 'mail.password' => $request->mail_password,
    //                 'mail.from.address' => $request->mail_from_address,
    //                 'mail.from.name' => $request->mail_from_name,
    //             ]
    //         );
    //         Mail::to($request->email)->send(new TestMail());
    //     } catch (\Exception $e) {
    //         return response()->json(
    //             [
    //                 'success' => false,
    //                 'message' => $e->getMessage(),
    //             ]
    //         );
    //     }

    //     return response()->json(
    //         [
    //             'success' => true,
    //             'message' => __('Email send Successfully'),
    //         ]
    //     );
    // }




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
