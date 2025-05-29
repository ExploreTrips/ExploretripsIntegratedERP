<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Utility;
use App\Helpers\MailHelper;
use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if(!$user){
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $clients = User::where('created_by', $user->creatorId())
                    ->where('type', 'client')
                    ->latest()
                    ->get();
        return view('clients.index', compact('clients'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        if ($user->can('create client')) {
                return view('clients.create');
            // if ($request->ajax) {
            //     return view('clients.createAjax');
            // } else {
            //     $customFields = CustomField::where('module', 'client')->get();
            //     dd($customFields);
            //     return view('clients.create', compact('customFields'));
            // }
        } else {
            // if ($request->ajax()) {
            //     return response()->json(['error' => __('Permission Denied.')], 401);
            // } else {
            //     return redirect()->back()->with('error', __('Permission Denied.'));
            // }
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('create client')) {
            $default_language = DB::table('settings')
                ->select('value')
                ->where('name', 'default_language')
                ->where('created_by', '=', auth()->user()->creatorId())
                ->first();

            $user = auth()->user();
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return $request->ajax
                    ? response()->json(['error' => $messages->first()], 401)
                    : redirect()->back()->with('error', $messages->first());
            }

            $enableLogin = 0;
            if (!empty($request->password_switch) && $request->password_switch == 'on') {
                $enableLogin = 1;

                $validator = \Validator::make(
                    $request->all(),
                    ['password' => 'required|min:6']
                );

                if ($validator->fails()) {
                    return redirect()->back()->with('error', $validator->errors()->first());
                }
            }

            $userpassword = $request->input('password');
            $creator = User::find($user->creatorId());
            $role = Role::findByName('client');
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $avatarPath = $file->storeAs('clients', $filename, 'public');
            }
            $client = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => !empty($userpassword) ? \Hash::make($userpassword) : null,
                'type' => 'client',
                'lang' => !empty($default_language) ? $default_language->value : 'en',
                'created_by' => $user->creatorId(),
                'email_verified_at' => now(),
                'is_enable_login' => $enableLogin,
                'avatar' => $avatarPath,
            ]);
            $settings = Utility::settings();
            if (!empty($settings['new_client']) && $settings['new_client'] == 1) {
                $client->assignRole($role);
                $client->password = $request->password;

                $clientArr = [
                    'client_name' => $client->name,
                    'client_email' => $client->email,
                    'client_password' => $client->password,
                ];
                $resp = MailHelper::sendEmailTemplate('new_client', [$client->email], $clientArr);

                return redirect()->route('clients.index')->with(
                    'success',
                    __('Client successfully added.') .
                    ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error']))
                        ? '<br> <span class="text-danger">' . $resp['error'] . '</span>'
                        : '')
                );
            }
            return redirect()->route('clients.index')->with('success', __('Client successfully created.'));
        } else {
            return $request->ajax
                ? response()->json(['error' => __('Permission Denied.')], 401)
                : redirect()->back()->with('error', __('Permission Denied.'));
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(User $client)
    {
        $user = auth()->user();
        if($user->can('edit client'))
        {
            if($client->created_by == $user->creatorId())
            {
                return view('clients.edit', compact('client'));
            }
            else
            {
                return response()->json(['error' => __('Invalid Client.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function update(User $client, Request $request)
    {
        if (Auth::user()->can('edit client')) {
            $user = Auth::user();
            if ($client->created_by == $user->creatorId()) {
                $validation = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $client->id,
                    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // avatar validation
                ];

                $post = [];
                $post['name'] = $request->name;

                if (!empty($request->password)) {
                    $validation['password'] = 'required';
                    $post['password'] = Hash::make($request->password);
                }

                $validator = \Validator::make($request->all(), $validation);
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                $post['email'] = $request->email;
                    if ($request->hasFile('avatar')) {
                    if (!empty($client->avatar) && \Storage::disk('public')->exists($client->avatar)) {
                        \Storage::disk('public')->delete($client->avatar);
                    }
                    $file = $request->file('avatar');
                    $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                    $avatarPath = $file->storeAs('clients', $filename, 'public');
                    $post['avatar'] = $avatarPath;
                }
                $client->update($post);
                // CustomField::saveData($client, $request->customField);
                return redirect()->back()->with('success', __('Client Updated Successfully!'));
            } else {
                return redirect()->back()->with('error', __('Invalid Client.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function destroy($id)
    {
        $user = \Auth::user();
        $client = User::find($id);
        if (!$client) {
            return redirect()->back()->with('error', __('Client not found.'));
        }
        if ($client->created_by != $user->creatorId()) {
            return redirect()->back()->with('error', __('Invalid Client.'));
        }
        if (!empty($client->avatar) && \Storage::disk('public')->exists($client->avatar)) {
            \Storage::disk('public')->delete($client->avatar);
        }
        $client->delete();
        return redirect()->back()->with('success', __('Client Deleted Successfully!'));
    }

    public function clientPassword($id)
    {
        $eId  = Crypt::decrypt($id);
        $user = User::find($eId);
        $client = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'client')->first();
        return view('clients.reset', compact('user', 'client'));
    }

    public function clientPasswordReset(Request $request, $id)
{
    $validator = Validator::make(
        $request->all(),
        [
            'password' => 'required|confirmed|min:6',
        ]
    );

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('modal', 'resetPasswordModal') // tell frontend which modal to reopen
            ->with('error', 'Password update failed. Please check your input.');
    }

    $user = User::findOrFail($id);
    $user->update([
        'password' => Hash::make($request->password)
    ]);

    return redirect()->route('clients.index')->with('success', __('Client password successfully updated.'));
}


}
