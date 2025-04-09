<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\Utility;

class CrossSite
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $creatorId = $user->creatorId();

            // Set timezone from settings
            $settings = Utility::settingsById($creatorId);
            if (!empty($settings['timezone'])) {
                Config::set('app.timezone', $settings['timezone']);
                date_default_timezone_set(Config::get('app.timezone', 'UTC'));
            }

            // Set locale
            app()->setLocale($user->lang ?? config('app.locale'));

            // Super admin check for pending updates
            if ($user->type === 'super admin') {
                $migrations = $this->getMigrations();
                $dbMigrations = $this->getExecutedMigrations();
                $moduleMigrations = glob(base_path('Modules/LandingPage/Database/Migrations/*.php'));
                $pendingUpdates = (count($migrations) + count($moduleMigrations)) - count($dbMigrations);

                if ($pendingUpdates > 0) {
                    Utility::addNewData();
                    User::defaultEmail();

                    $companies = User::where('type', 'company')->get();
                    foreach ($companies as $companyUser) {
                        $companyUser->userDefaultDataRegister($companyUser->id);
                    }

                    // return redirect()->route('LaravelUpdater::welcome');
                }
            }
        }

        return $next($request);
    }

    // Dummy methods for compatibility — replace with your actual logic
    protected function getMigrations()
    {
        return glob(database_path('migrations/*.php'));
    }

    protected function getExecutedMigrations()
    {
        return \DB::table('migrations')->pluck('migration')->toArray();
    }
}
