<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        // return view('user.index');
    }
}
