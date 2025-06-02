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

    public static function priceFormat($price)
    {
        $number = explode('.', $price);
        $length = strlen(trim($number[0]));
        $float_number = Utility::getValByName('float_number') == 'dot' ? '.' : ',';

        if ($length > 3) {
            $decimal_separator = Utility::getValByName('decimal_separator') == 'dot' ? ',' : ',';
            $thousand_separator = Utility::getValByName('thousand_separator') == 'dot' ? '.' : ',';
        } else {
            $decimal_separator = Utility::getValByName('decimal_separator') == 'dot' ? '.' : ',';
            $thousand_separator = Utility::getValByName('thousand_separator') == 'dot' ? '.' : ',';
        }
        $currency = Utility::getValByName('currency_symbol') == 'withcurrencysymbol' ? Utility::getValByName('site_currency_symbol') : Utility::getValByName('site_currency');
        $settings = Utility::settings();
        // dd($currency,$settings['site_currency']);
        $decimal_number = Utility::getValByName('decimal_number') ? Utility::getValByName('decimal_number') : 0;
        $currency_space = Utility::getValByName('currency_space');
        $price = number_format($price, $decimal_number, $decimal_separator, $thousand_separator);
        if ($float_number == 'dot') {
            $price = preg_replace('/' . preg_quote($thousand_separator, '/') . '([^' . preg_quote($thousand_separator, '/') . ']*)$/', $float_number . '$1', $price);
        } else {
            $price = preg_replace('/' . preg_quote($decimal_separator, '/') . '([^' . preg_quote($decimal_separator, '/') . ']*)$/', $float_number . '$1', $price);
        }
        return (($settings['site_currency_symbol_position'] == "pre") ? $currency : '') . ($currency_space == 'withspace' ? ' ' : '') . $price . ($currency_space == 'withspace' ? ' ' : '') . (($settings['site_currency_symbol_position'] == "post") ? $currency : '');
    }
}
