<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function loginSocial($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callbackSocial($provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->user();
            $user         = User::where('provider_id', $providerUser->id)->first();
            if ($user) {
                Auth::login($user);
                if ($user->type == 'company' || $user->type == 'super admin' || $user->type == 'client') {
                    return redirect()->intended(RouteServiceProvider::HOME);
                } else {
                    return redirect()->intended(RouteServiceProvider::EMPHOME);
                }
            } else {
                $userCompany = User::where('email', $providerUser->email)->first();
                if ($userCompany) {
                    $update_user = [
                        'provider_id'   => $providerUser->id,
                        'provider_name' => $provider,
                    ];
                    $updateUser = User::where('email', $providerUser->email)->update($update_user);
                    Auth::login($userCompany);

                    // $newUser = User::updateOrCreate([
                    //     'email ' => $providerUser->email,
                    // ], [
                    //     'provider_id'   => $providerUser->id,
                    //     'provider_name' => $provider,
                    // ]);
                    // Auth::login($newUser);
                    if ($userCompany->type == 'company' || $userCompany->type == 'super admin' || $userCompany->type == 'client') {
                        return redirect()->intended(RouteServiceProvider::HOME);
                    } else {
                        return redirect()->intended(RouteServiceProvider::EMPHOME);
                    }
                } else {
                    return redirect()->intended(route('register'));
                }
            }
        } catch (Exception $e) {
            //dd($e->getMessage());
            return redirect()->intended(route('login'));
        }
    }
}
