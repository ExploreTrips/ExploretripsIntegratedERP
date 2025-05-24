<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Requests\BranchRequest;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if($user->can('manage branch'))
        {
            $branches = Branch::where('created_by', '=', $user->creatorId())->get();
            return view('branch.index', compact('branches'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

       public function create()
    {
        if(auth()->user()->can('create branch'))
        {
            return view('branch.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(BranchRequest $request)
    {
        if (\Auth::user()->can('create branch')) {
            $branch = new Branch();
            $branch->name = $request->name;
            $branch->created_by = \Auth::user()->creatorId();
            $branch->save();
            return redirect()->route('branch.index')->with('success', __('Branch successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        $user = auth()->user();
        if($user->can('edit branch'))
        {
            if($branch->created_by === $user->creatorId())
            {
                return view('branch.edit', compact('branch'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
{
    $user = auth()->user();
    if ($user->can('edit branch')) {
        if ($branch->created_by === $user->creatorId()) {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $branch->update([
                'name' => $request->name,
            ]);

            return redirect()->route('branch.index')->with('success', __('Branch successfully updated.'));
        }
        return redirect()->back()->with('error', __('Permission denied.'));
    }
    return redirect()->back()->with('error', __('Permission denied.'));
}




    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Branch $branch)
    {
        $user = auth()->user();
        if($user->can('delete branch'))
        {
            if($branch->created_by === $user->creatorId())
            {
                $branch->delete();
                return redirect()->route('branch.index')->with('success', __('Branch successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
