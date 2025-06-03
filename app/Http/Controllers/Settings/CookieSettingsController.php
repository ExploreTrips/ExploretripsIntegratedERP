<?php

namespace App\Http\Controllers\Settings;

use DB;
use Auth;
use DateTime;
use App\Models\Utility;
use WhichBrowser\Parser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CookieSettingsController extends Controller
{
     public function CookieConsent(Request $request)
    {
        $settings = Utility::settings();
        if ($settings['enable_cookie'] == "on" && $settings['cookie_logging'] == "on") {
            $allowed_levels = ['necessary', 'analytics', 'targeting'];
            $levels = array_filter($request['cookie'], function ($level) use ($allowed_levels) {
                return in_array($level, $allowed_levels);
            });
            $whichbrowser = new Parser($_SERVER['HTTP_USER_AGENT']);
            // Generate new CSV line
            $browser_name = $whichbrowser->browser->name ?? null;
            $os_name = $whichbrowser->os->name ?? null;
            $browser_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
            $device_type = Utility::get_device_type($_SERVER['HTTP_USER_AGENT']);
            $ip = '49.36.83.154';
            $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));

            $date = (new DateTime())->format('Y-m-d');
            $time = (new \DateTime())->format('H:i:s') . ' UTC';

            $new_line = implode(',', [
                $ip,
                $date,
                $time,
                json_encode($request['cookie']),
                $device_type,
                $browser_language,
                $browser_name,
                $os_name,
                isset($query) ? $query['country'] : '',
                isset($query) ? $query['region'] : '',
                isset($query) ? $query['regionName'] : '',
                isset($query) ? $query['city'] : '',
                isset($query) ? $query['zip'] : '',
                isset($query) ? $query['lat'] : '',
                isset($query) ? $query['lon'] : ''
            ]);

            if (!file_exists(storage_path() . '/uploads/sample/data.csv')) {

                $first_line = 'IP,Date,Time,Accepted cookies,Device type,Browser language,Browser name,OS Name,Country,Region,RegionName,City,Zipcode,Lat,Lon';
                file_put_contents(storage_path() . '/uploads/sample/data.csv', $first_line . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            file_put_contents(storage_path() . '/uploads/sample/data.csv', $new_line . PHP_EOL, FILE_APPEND | LOCK_EX);
            return response()->json('success');
        }
        return response()->json('error');
    }

    public function saveCookieSettings(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'cookie_title' => 'required',
                'cookie_description' => 'required',
                'strictly_cookie_title' => 'required',
                'strictly_cookie_description' => 'required',
                'more_information_description' => 'required',
                'contactus_url' => 'required',
            ]
        );

        $post = $request->all();

        unset($post['_token']);

        if ($request->enable_cookie) {
            $post['enable_cookie'] = 'on';
        } else {
            $post['enable_cookie'] = 'off';
        }
        if ($request->cookie_logging) {
            $post['cookie_logging'] = 'on';
        } else {
            $post['cookie_logging'] = 'off';
        }

        $post['cookie_title'] = $request->cookie_title;
        $post['cookie_description'] = $request->cookie_description;
        $post['strictly_cookie_title'] = $request->strictly_cookie_title;
        $post['strictly_cookie_description'] = $request->strictly_cookie_description;
        $post['more_information_description'] = $request->more_information_description;
        $post['contactus_url'] = $request->contactus_url;

        $settings = Utility::settings();
        foreach ($post as $key => $data) {

            if (in_array($key, array_keys($settings))) {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $data,
                        $key,
                        \Auth::user()->creatorId(),
                        date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s'),
                    ]
                );
            }
        }
        return redirect()->back()->with('success', 'Cookie setting successfully saved.');
    }

}
