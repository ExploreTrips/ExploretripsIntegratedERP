<?php

namespace App\Helpers;

use App\Models\Branch;
use App\Models\Utility;
use App\Models\Employees;

class CustomHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public static function employeeIdFormat($branch_id)
    {
        $branch = Branch::find($branch_id);
        if ($branch && $branch->name) {
            $cleanName = strtoupper(preg_replace('/\s+/', '', $branch->name));
            $name = substr($cleanName, 0, 3);
            // print_r($name);die;
            return $name;

        }
        return '';
    }

    public static function dateFormat($date)
    {
        $settings = Utility::settings();
        return date($settings['site_date_format'], strtotime($date));
    }
}
