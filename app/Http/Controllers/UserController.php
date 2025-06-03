<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Crypt;
use Validator;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use App\Models\Employees;
use App\Helpers\MailHelper;
use App\Models\CustomField;
use App\Models\LoginDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Lab404\Impersonate\Impersonate;
use Illuminate\Support\Facades\Storage;

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
        if (!auth()->user()->can('create user')) {
            return redirect()->back();
        }

        $default_language = DB::table('settings')->select('value')
            ->where('name', 'default_language')
            ->where('created_by', \Auth::user()->creatorId())
            ->first();

        $creatorId = auth()->user()->creatorId();
        $settings = Utility::settings();

        $enableLogin = 0;
        $psw = null;
        $avatarPath = null;

        if (!empty($request->password_switch) && $request->password_switch == 'on') {
            $enableLogin = 1;

            $validator = Validator::make($request->all(), ['password' => 'required|min:6']);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $psw = $request->password;
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $avatarPath = $file->storeAs('avatars', $filename, 'public');
        }

        if (auth()->user()->type == 'super admin') {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    'email' => 'required|email|unique:users',
                    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            do {
                $code = rand(100000, 999999);
            } while (User::where('referral_code', $code)->exists());

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $psw ? Hash::make($psw) : null;
            $user->type = 'company';
            $user->default_pipeline = 1;
            $user->plan = Plan::first()->id ?? 1;
            $user->lang = !empty($default_language) ? $default_language->value : 'en';
            $user->referral_code = $code;
            $user->created_by = $creatorId;
            $user->email_verified_at = $settings['email_verification'] === 'on' ? null : now();
            $user->is_enable_login = $enableLogin;
            $user->avatar = $avatarPath;
            $user->save();
            $role_r = Role::findByName('company');
            $user->assignRole($role_r);
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    'email' => 'required|email|unique:users',
                    'role' => 'required',
                    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $objUser = User::find($creatorId);
            $total_user = $objUser->countUsers();
            $plan = Plan::find($objUser->plan);

            if ($total_user < $plan->max_users || $plan->max_users == -1) {
                $role_r = Role::findById($request->role);

                $userData = $request->all();
                $userData['password'] = $psw ? Hash::make($psw) : null;
                $userData['type'] = $role_r->name;
                $userData['lang'] = !empty($default_language) ? $default_language->value : 'en';
                $userData['created_by'] = $creatorId;
                $userData['email_verified_at'] = now();
                $userData['is_enable_login'] = $enableLogin;
                $userData['avatar'] = $avatarPath;

                $user = User::create($userData);
                $user->assignRole($role_r);

                if ($userData['type'] !== 'client') {
                    Utility::employeeDetails($user->id, $creatorId);
                }
            } else {
                return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
            }
        }
        if (!empty($user)) {
            if (!empty($settings['new_user']) && $settings['new_user'] == 1) {
                $user->password = $psw;
                $user->type = $role_r->name;
                $user->userDefaultDataRegister($user->id);

                $userArr = [
                    'email' => $user->email,
                    'password' => $psw,
                ];

                $resp = MailHelper::sendEmailTemplate('new_user', [$user->id => $user->email], $userArr);

                $successMsg = (auth()->user()->type == 'super admin')
                    ? __('Company successfully created.')
                    : __('User successfully created.');

                if (!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) {
                    $successMsg .= '<br> <span class="text-danger">' . $resp['error'] . '</span>';
                }
                return redirect()->route('users.index')->with('success', $successMsg);
            }
            return redirect()->route('users.index')->with('success', auth()->user()->type == 'super admin'
                ? __('Company successfully created.')
                : __('User successfully created.'));
        }
        return redirect()->back()->with('error', __('Something went wrong while creating user.'));
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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // print_r($fileNameToStore);die;
            $dir = 'avatars';
            $storageDisk = 'public';

        if (!empty($user->avatar)) {
            $oldPath = $dir . '/' . $user->avatar;
            if (Storage::disk($storageDisk)->exists($oldPath)) {
                Storage::disk($storageDisk)->delete($oldPath);
            }
        }
        $path = $file->storeAs($dir, $fileNameToStore, $storageDisk);
        $user->avatar = $fileNameToStore;
    }

    $user->name = $input['name'];
    $user->email = $input['email'];
    $user->type = $input['type'];

    $user->save();
        if ($request->has('customField')) {
            CustomField::saveData($user, $request->customField);
        }
        if (\Auth::user()->type !== 'super admin') {
            Utility::employeeDetailsUpdate($user->id, \Auth::user()->creatorId());
        }

        $message = \Auth::user()->type === 'super admin'
            ? __('Company successfully updated.')
            : __('User successfully updated.');

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
        if (!auth()->user()->can('delete user')) {
            return redirect()->back();
        }

        if ($id == 2) {
            return redirect()->back()->with('error', __('You cannot delete the default company.'));
        }
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', __('User not found.'));
        }
        if (auth()->user()->type == 'super admin') {
            User::where('created_by', $id)->delete();
            Employees::where('created_by', $id)->delete();
            $user->delete();
            return redirect()->back()->with('success', __('Company successfully deleted.'));
        }

        if (auth()->user()->type == 'company') {
            $employeeDeleted = Employees::where('user_id', $user->id)->delete();
            if ($employeeDeleted) {
                $userDeleted = $user->delete();
                if ($userDeleted) {
                    return redirect()->route('users.index')->with('success', __('User successfully deleted.'));
                } else {
                    return redirect()->back()->with('error', __('Failed to delete user.'));
                }
            } else {
                return redirect()->back()->with('error', __('Failed to delete employee record.'));
            }
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', __('User successfully deleted.'));
    }


    public function LoginManage($id)
    {
        $eId = Crypt::decrypt($id);
        // echo $eId;die;
        $user = User::find($eId);
        // dd($user);
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

        public function userLog(Request $request)
    {
        $filteruser = User::where('created_by', \Auth::user()->creatorId())
            ->pluck('name', 'id')
            ->prepend('Select User', '');
        $query = DB::table('login_details')
            ->join('users', 'login_details.user_id', '=', 'users.id')
            ->select(
                'login_details.*',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'users.type as user_type'
            )
            ->where('login_details.created_by', \Auth::user()->creatorId());
        $month = $request->input('month');
        if ($month) {
            $query->whereMonth('date', date('m', strtotime($month)))
                ->whereYear('date', date('Y', strtotime($month)));
        } else {
            $query->whereMonth('date', now()->month)
                ->whereYear('date', now()->year);
        }

        if ($request->filled('users')) {
            $query->where('login_details.user_id', $request->users);
        }

        $userdetails = $query->orderBy('date', 'desc')->get();
        $last_login_details = LoginDetail::where('created_by', \Auth::user()->creatorId())->get();
        return view('user.userlog', compact('userdetails', 'last_login_details', 'filteruser'));
    }

    public function userLogView($id)
    {
        $users = LoginDetail::find($id);
        return view('user.userlogview', compact('users'));
    }

    public function userLogDestroy($id)
    {
        // echo $id;die;
        $users = LoginDetail::where('id', $id)->delete();
        // dd($users);
        return redirect()->back()->with('success', 'User successfully deleted.');
    }

    public function profile()
    {
        $userDetail = Auth::user();
        return view('user.profile', compact('userDetail'));
    }

    public function editprofile(Request $request)
    {
        $userDetail = Auth::user();
        $user = User::findOrFail($userDetail->id);
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $dir = 'avatars';
            $storageDisk = 'public';
            if (!empty($user->avatar)) {
                $oldPath = $dir . '/' . $user->avatar;
                if (Storage::disk($storageDisk)->exists($oldPath)) {
                    Storage::disk($storageDisk)->delete($oldPath);
                }
            }
            $path = $file->storeAs($dir, $fileNameToStore, $storageDisk);
            $user->avatar = $fileNameToStore;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return redirect()->route('profile')->with('success', 'Profile successfully updated.');
    }

    public function updatePassword(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('profile', Auth::id())->with('error', __('Something is wrong.'));
        }

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->route('profile', $user->id)->with('error', __('Please enter the correct current password.'));
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('profile', $user->id)->with('success', __('Password successfully updated.'));
    }















}
