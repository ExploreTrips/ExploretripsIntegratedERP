<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'max_users',
        'max_customers',
        'max_venders',
        'max_clients',
        'trial',
        'trial_days',
        'description',
        'image',
        'crm',
        'hrm',
        'account',
        'project',
        'pos',
        'chatgpt',
        'storage_limit',
    ];

    public static $cachedPlan = null;

    public static $arrDuration = [
        'lifetime' => 'Lifetime',
        'month' => 'Per Month',
        'year' => 'Per Year',
    ];

    public function status(): array
    {
        return [
            __('Lifetime'),
            __('Per Month'),
            __('Per Year'),
        ];
    }

    public static function totalPlan(): int
    {
        return self::count();
    }

    public static function mostPurchasedPlan(): ?Plan
    {
        $freePlan = self::where('price', '<=', 0)->value('id');

        if (!$freePlan) {
            Log::error('No free plan found.');
            return null;
        }

        $plan = User::select(DB::raw('count(*) as total'), 'plan')
            ->where('type', 'company')
            ->where('plan', '!=', $freePlan)
            ->groupBy('plan')
            ->orderByDesc('total')
            ->first();

        return $plan ? self::find($plan->plan) : null;
    }



    public static function getPlan($id)
    {


        if ($id === null) {
            return null;
        }

        if(self::$cachedPlan == null)
        {
            $plan = Plan::find($id);
            self::$cachedPlan = $plan;
        }

        return self::$cachedPlan;
    }




}
