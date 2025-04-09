<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Crypt;
use Validator;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Lab404\Impersonate\Impersonate;

class UserController extends Controller
{
    public function index(){
        User::defaultEmail();
        $user = auth()->user();
        // print_r($user);die;
        if ($user->can('manage user')) {
            if ($user->type == 'super admin') {
                $users = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'company')->with(['currentPlan'])->get();
            } else {
                $users = User::where('created_by', '=', $user->creatorId())->where('type', '!=', 'client')->with(['currentPlan'])->get();
            }
            return view('user.index')->with('users', $users);
        } else {
            return redirect()->back();
        }
    }

    public function create()
    {
        $customFields = CustomField::where('created_by', '=', auth()->user()->creatorId())->where('module', '=', 'user')->get();
        $user = auth()->user();
        $roles = Role::where('created_by', '=', $user->creatorId())->where('name', '!=', 'client')->get()->pluck('name', 'id');
        if (auth()->user()->can('create user')) {
            return view('user.create', compact('roles', 'customFields'));
        } else {
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create user')) {
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->where('created_by', '=', \Auth::user()->creatorId())->first();
            $objUser = \Auth::user()->creatorId();
            if (\Auth::user()->type == 'super admin') {
                $validator = Validator::make(
                    $request->all(), [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }
                $enableLogin = 0;
                if (!empty($request->password_switch) && $request->password_switch == 'on') {
                    $enableLogin = 1;
                    $validator = \Validator::make(
                        $request->all(), ['password' => 'required|min:6']
                    );
                    if ($validator->fails()) {
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }
                $userpassword = $request->input('password');
                $settings = Utility::settings();
                do {
                    $code = rand(100000, 999999);
                } while (User::where('referral_code', $code)->exists());
                $user = new User();
                $user['name'] = $request->name;
                $user['email'] = $request->email;
                $psw = $request->password;
                $user['password'] = !empty($userpassword)?Hash::make($userpassword) : null;
                $user['type'] = 'company';
                $user['default_pipeline'] = 1;
                $user['plan'] = 1;
                $user['lang'] = !empty($default_language) ? $default_language->value : 'en';
                $user['referral_code'] = $code;
                $user['created_by'] = \Auth::user()->creatorId();
                $user['plan'] = Plan::first()->id;
                if ($settings['email_verification'] == 'on') {
                    $user['email_verified_at'] = null;
                } else {
                    $user['email_verified_at'] = date('Y-m-d H:i:s');
                }
                $user['is_enable_login'] = $enableLogin;
                $user->save();
                $role_r = Role::findByName('company');
                $user->assignRole($role_r);
            } else {
                $validator = \Validator::make(
                    $request->all(), [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users',
                        'role' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }
                $enableLogin = 0;
                if (!empty($request->password_switch) && $request->password_switch == 'on') {
                    $enableLogin = 1;
                    $validator = \Validator::make(
                        $request->all(), ['password' => 'required|min:6']
                    );
                    if ($validator->fails()) {
                        return redirect()->back()->with('error', $validator->errors()->first());
                    }
                }
                $objUser = User::find($objUser);
                $user = User::find(\Auth::user()->created_by);
                $total_user = $objUser->countUsers();
                $plan = Plan::find($objUser->plan);
                $userpassword = $request->input('password');
                if ($total_user < $plan->max_users || $plan->max_users == -1) {
                    $role_r = Role::findById($request->role);
                    $psw = $request->password;
                    $request['password'] = !empty($userpassword)?\Hash::make($userpassword) : null;
                    $request['type'] = $role_r->name;
                    $request['lang'] = !empty($default_language) ? $default_language->value : 'en';
                    $request['created_by'] = \Auth::user()->creatorId();
                    $request['email_verified_at'] = date('Y-m-d H:i:s');
                    $request['is_enable_login'] = $enableLogin;
                    $user = User::create($request->all());
                    $user->assignRole($role_r);
                    if ($request['type'] != 'client') {
                        Utility::employeeDetails($user->id, \Auth::user()->creatorId());
                    }
                } else {
                    return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
                }
            }
            // Send Email
            $setings = Utility::settings();
            if ($setings['new_user'] == 1) {
                $user->password = $psw;
                $user->type = $role_r->name;
                $user->userDefaultDataRegister($user->id);
                $userArr = [
                    'email' => $user->email,
                    'password' => $user->password,
                ];
                $resp = Utility::sendEmailTemplate('new_user', [$user->id => $user->email], $userArr);
                if (\Auth::user()->type == 'super admin') {
                    return redirect()->route('users.index')->with('success', __('Company successfully created.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
                } else {
                    return redirect()->route('users.index')->with('success', __('User successfully created.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
                }
            }
            if (\Auth::user()->type == 'super admin') {
                return redirect()->route('users.index')->with('success', __('Company successfully created.'));
            } else {
                return redirect()->route('users.index')->with('success', __('User successfully created.'));
            }
        } else {
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $authUser = \Auth::user();
        if (!$authUser->can('edit user')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $user = User::findOrFail($id);
        $roles = Role::where('created_by', $authUser->creatorId())
                     ->where('name', '!=', 'client')
                     ->pluck('name', 'id');
        $user->customField = CustomField::getData($user, 'user');
        $customFields = CustomField::where('created_by', $authUser->creatorId())
                                   ->where('module', 'user')
                                   ->get();
        return view('user.edit', compact('user', 'roles', 'customFields'));
    }

    public function update(Request $request, $id)
    {
        if (!\Auth::user()->can('edit user')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $user = User::findOrFail($id);
        $validationRules = [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users,email,' . $id,
        ];
        if (\Auth::user()->type !== 'super admin') {
            $validationRules['role'] = 'required';
        }
        $validator = \Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }
        $input = $request->all();
        if (\Auth::user()->type === 'super admin') {
            $role = Role::where('name', 'company')->first();
        } else {
            $role = Role::findOrFail($request->role);
        }
        $input['type'] = $role->name;
        $user->fill($input)->save();
        $user->roles()->sync([$role->id]);
        if ($request->has('customField')) {
            CustomField::saveData($user, $request->customField);
        }
        if (\Auth::user()->type !== 'super admin') {
            Utility::employeeDetailsUpdate($user->id, \Auth::user()->creatorId());
        }
        $message = Auth::user()->type === 'super admin'? __('Company successfully updated.'): __('User successfully updated.');
        return redirect()->route('users.index')->with('success', $message);
    }

    public function LoginWithCompany(Request $request,$id)
    {
        $user = User::findOrFail($id);
            if ($user && auth()->check()) {
                if ($user->is_enable_login != 1) {
                    return redirect()->back()->with('error', 'This company login is currently disabled.');
                }
            Impersonate::take($request->user(), $user);
            return redirect('/account-dashboard')->with('success', 'You are now logged in as the selected company.');

        }
        return redirect()->back()->with('error', 'Unable to impersonate the user.');
    }

    public function ExitCompany(Request $request)
    {
        auth()->user()->leaveImpersonation($request->user());
        return redirect('/dashboard');
            return redirect('/dashboard')->with('success', 'Impersonation ended successfully.');
            // return redirect()->back()->with('error', 'No impersonation session found.');
    }

    public function userPassword($id)
    {
        // $eId = Crypt::decrypt($id);
        $user = User::findOrFail($id);
        return view('user.reset', compact('user'));
    }

    public function userPasswordReset(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::findOrFail($id);
        $user->forceFill([
            'password' => \Hash::make($request->password),
            'is_enable_login' => 1,
        ])->save();

        // print_r($user);die;
        $message = \Auth::user()->type == 'super admin'
            ? 'Company Password successfully updated.'
            : 'User Password successfully updated.';

        return redirect()->route('users.index')->with('success', $message);
    }

    public function destroy($id)
    {
        if (auth()->user()->can('delete user')) {
            if ($id == 2) {
                return redirect()->back()->with('error', __('You can not delete By default Company'));
            }
            $user = User::find($id);
            if ($user) {
                if (auth()->user()->type == 'super admin') {
                    // $transaction = ReferralTransaction::where('company_id' , $id)->delete();
                    $users = User::where('created_by', $id)->delete();
                    // $employee = Employee::where('created_by', $id)->delete();
                    $user->delete();
                    return redirect()->back()->with('success', __('Company Successfully deleted'));
                }

                // if (auth()->user()->type == 'company') {
                //     $employee = Employee::where(['user_id' => $user->id])->delete();
                //     if ($employee) {
                //         $delete_user = User::where(['id' => $user->id])->delete();
                //         if ($delete_user) {
                //             return redirect()->route('users.index')->with('success', __('User successfully deleted .'));
                //         } else {
                //             return redirect()->back()->with('error', __('Something is wrong.'));
                //         }
                //     } else {
                //         return redirect()->back()->with('error', __('Something is wrong.'));
                //     }
                // }
                // return redirect()->route('users.index')->with('success', __('User successfully deleted .'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        } else {
            return redirect()->back();
        }
    }

    public function LoginManage($id)
    {
        // $eId = \Crypt::decrypt($id);
        $user = User::find($id);
        $authUser = \Auth::user();

        if ($user->is_enable_login == 1) {
            $user->is_enable_login = 0;
            $user->save();
            if($authUser->type == 'super admin')
            {
                return redirect()->back()->with('success', __('Company login disable successfully.'));
            }
            else
            {
                return redirect()->back()->with('success', __('User login disable successfully.'));
            }
        } else {
            $user->is_enable_login = 1;
            $user->save();
            if($authUser->type == 'super admin')
            {
                return redirect()->back()->with('success', __('Company login enable successfully.'));
            }
            else
            {
                return redirect()->back()->with('success', __('User login enable successfully.'));
            }
        }
    }
}
