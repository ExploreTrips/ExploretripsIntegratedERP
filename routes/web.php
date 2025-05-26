<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\SettingsContrpller;
use App\Http\Controllers\HrmSystem\EmployeeController;
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
Route::get('/hrm-dashboard', [DashboardController::class, 'hrm_dashboard_index'])->name('hrm.dashboard')->middleware(['auth', 'revalidate']);

// Superadmin Routes
// Language Routes
Route::group([
    'middleware' => [
        'auth',
        'crosssite'
    ],
],function(){

    // LanguageController Routes
    Route::get('change-language/{lang}', [LanguageController::class, 'changeLanguage'])->name('change.language');

    // UserController Routes
    Route::resource('users', UserController::class);
    Route::get('users/{id}/login-with-company', [UserController::class, 'LoginWithCompany'])->name('login.with.company');
    Route::get('login-with-company/exit', [UserController::class, 'ExitCompany'])->name('exit.company');
    Route::any('user-reset-password/{id}', [UserController::class, 'userPassword'])->name('users.reset');
    Route::post('user-reset-password/{id}', [UserController::class, 'userPasswordReset'])->name('user.password.update');
    Route::get('user-login/{id}', [UserController::class, 'LoginManage'])->name('users.login');

    // SystemController Routes
    Route::resource('systems', SettingsController::class);

    // MailConfiguration Settings
    Route::post('email-settings', [SettingsController::class, 'saveEmailSettings'])->name('email.settings');
    Route::get('test-mail', [SettingsController::class, 'mailTest'])->name('test.mail');
    // Route::post('test-mail/send', [SettingsController::class, 'testSendMail'])->name('test.send.mail');


    // Template Routes
    Route::get('email_template_lang/{id}/{lang?}', [MailController::class, 'manageEmailLang'])->name('manage.email.language');

    // EmployeeController Routes
    Route::resource('employee', EmployeeController::class);
    Route::get('/get-employee-id/{branch_id}', [EmployeeController::class, 'getEmployeeId']);
    Route::post('/get-departments', [EmployeeController::class, 'getDepartments']);
    Route::post('/get-designations', [EmployeeController::class, 'getDesignations'])->name('get.designations');
    Route::get('import/employee/file', [EmployeeController::class, 'fileImport'])->name('employee.file.import');
    Route::get('import/employee/modal', [EmployeeController::class, 'fileImportModal'])->name('employee.import.modal');


    // HrmSystem Setup Routes
    Route::resource('branch', BranchController::class);
    Route::resource('document', DocumentController::class);

    // UserLogHistory Routes
    Route::get('/userlogs', [UserController::class, 'userLog'])->name('user.userlog');
    Route::get('userlogs/{id}', [UserController::class, 'userLogView'])->name('user.userlogview');
    Route::delete('userlogs/{id}', [UserController::class, 'userLogDestroy'])->name('user.userlogdestroy');



});

// cache
Route::get('/config-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success', 'Cache Clear Successfully');
})->name('config.cache');





Route::any('/cookie-consent', [SystemController::class, 'CookieConsent'])->name('cookie-consent');
