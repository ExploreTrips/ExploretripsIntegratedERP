<?php

use App\Http\Controllers\Dashboard\DashboardController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });



require __DIR__ . '/auth.php';

Route::get('/account-dashboard', [DashboardController::class, 'account_dashboard_index'])->name('dashboard')->middleware('auth');
Route::get('dashboard', [DashboardController::class, 'clientView'])->name('client.dashboard.view')->middleware('auth');





// cache
Route::get('/config-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success', 'Cache Clear Successfully');
})->name('config.cache');





Route::any('/cookie-consent', [SystemController::class, 'CookieConsent'])->name('cookie-consent');
