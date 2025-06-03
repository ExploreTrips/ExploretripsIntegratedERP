<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Client\CientController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\HrmSystem\PayrollController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\SettingsContrpller;
use App\Http\Controllers\HrmSystem\EmployeeController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HrmSystem\PayslipTypeController;
use App\Http\Controllers\Settings\CookieSettingsController;
use App\Http\Controllers\Settings\StorageSettingsController;
use App\Http\Controllers\HrmSystem\HrmSystemSetup\AllowanceOptionController;


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
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('edit-profile', [UserController::class, 'editprofile'])->name('update.account');
    Route::post('change-password', [UserController::class, 'updatePassword'])->name('update.password');


    // SettingsController Routes
    Route::resource('systems', SettingsController::class);

    // MailConfiguration Settings
    Route::post('email-settings', [SettingsController::class, 'saveEmailSettings'])->name('email.settings');
    Route::get('test-mail', [SettingsController::class, 'mailTest'])->name('test.mail');
    // Route::post('test-mail/send', [SettingsController::class, 'testSendMail'])->name('test.send.mail');

    // Payment Settings Routes
    Route::post('stripe-settings', [SettingsController::class, 'savePaymentSettings'])->name('payment.settings');

    // Template Routes
    Route::get('email_template_lang/{id}/{lang?}', [MailController::class, 'manageEmailLang'])->name('manage.email.language');

    // StorageSettings Routes
    Route::post('storage-settings', [StorageSettingsController::class, 'storageSettingStore'])->name('storage.setting.store');
    Route::post('cookie-setting', [CookieSettingsController::class, 'saveCookieSettings'])->name('cookie.setting');


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
    Route::resource('paysliptype', PayslipTypeController::class);
    Route::resource('allowanceoption', AllowanceOptionController::class);

    // UserLogHistory Routes
    Route::get('/userlogs', [UserController::class, 'userLog'])->name('user.userlog');
    Route::get('userlogs/{id}', [UserController::class, 'userLogView'])->name('user.userlogview');
    Route::delete('userlogs/{id}', [UserController::class, 'userLogDestroy'])->name('user.userlogdestroy');

    // Role&Permission Routes
    Route::resource('roles', RoleController::class);

    // Client Routes
    Route::resource('clients', ClientController::class);
    Route::any('client-reset-password/{id}', [ClientController::class, 'clientPassword'])->name('clients.reset');
    Route::post('client-reset-password/{id}', [ClientController::class, 'clientPasswordReset'])->name('client.password.update');
    // Payroll Routes
    Route::resource('setsalary', PayrollController::class);
    // Payment Settings

});

Route::any('/cookie-consent', [CookieSettingsController::class, 'CookieConsent'])->name('cookie-consent');






