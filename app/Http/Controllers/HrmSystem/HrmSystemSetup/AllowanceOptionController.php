<?php

namespace App\Http\Controllers\HrmSystem\HrmSystemSetup;

use Illuminate\Http\Request;
use App\Models\AllowanceOptions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AllowanceOptionController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('manage allowance option'))
        {
            $allowanceoptions = AllowanceOptions::where('created_by', '=', Auth::user()->creatorId())->get();
            return view('allowanceoption.index', compact('allowanceoptions'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
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
