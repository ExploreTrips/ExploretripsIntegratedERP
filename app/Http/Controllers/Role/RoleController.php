<?php

namespace App\Http\Controllers\Role;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('manage role')) {
            $roles = Role::where('created_by', Auth::user()->creatorId())->get();
            return view('role.index', compact('roles'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create role'))
        {
            $user = Auth::user();
            if($user->type == 'super admin')
            {
                $permissions = Permission::all()->pluck('name', 'id')->toArray();
            }
            else
            {
                $permissions = new Collection();
                foreach($user->roles as $role)
                {
                    $permissions = $permissions->merge($role->permissions);
                }
                $permissions = $permissions->pluck('name', 'id')->toArray();
            }
            return view('role.create', ['permissions' => $permissions]);
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create role')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $request->validate([
            'name' => 'required|max:100|unique:roles,name,NULL,id,created_by,' . Auth::user()->creatorId(),
            'permissions' => 'required|array|min:1',
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->created_by = Auth::user()->creatorId();
        $role->save();

        foreach ($request->permissions as $permissionId) {
            $permission = Permission::findOrFail($permissionId);
            $role->givePermissionTo($permission);
        }
        return redirect()->route('roles.index')->with('success', 'Role "' . $role->name . '" created successfully.');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function edit(Role $role)
    {
        if (Auth::user()->can('edit role')) {
            $user = Auth::user();

            if ($user->type === 'super admin') {
                $permissions = Permission::all()->pluck('name', 'id')->toArray();
            } else {
                $allPermissions = new Collection();
                foreach ($user->roles as $role1) {
                    $allPermissions = $allPermissions->merge($role1->permissions);
                }
                $permissions = $allPermissions->pluck('name', 'id')->toArray();
            }
            return view('role.edit', compact('role', 'permissions'));
        }
        return redirect()->back()->with('error', 'Permission denied.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
