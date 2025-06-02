<?php

namespace App\Http\Controllers\HrmSystem\HrmSystemSetup;

use App\Models\PayslipTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PayslipTypeController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('manage payslip type'))
        {
            //  $user = auth()->user()->creatorId();
            // echo $user;die;
            $paysliptypes = PayslipTypes::where('created_by', Auth::user()->creatorId())->get();
            // print_r($paysliptypes);die;
            return view('paysliptype.index', compact('paysliptypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(Auth::user()->can('create payslip type'))
        {
            return view('paysliptype.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create payslip type')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $request->validate([
            'name' => 'required|max:20',
        ]);
        $paysliptype = new PayslipTypes();
        $paysliptype->name = $request->name;
        $paysliptype->created_by = Auth::user()->creatorId();
        $paysliptype->save();
        return redirect()->route('paysliptype.index')->with('success', __('Payslip ' .$paysliptype->name. ' successfully created.'));
    }


    public function show(PayslipType $paysliptype)
    {
        return redirect()->route('paysliptype.index');
    }

    public function edit(PayslipTypes $paysliptype)
    {
        if (!Auth::user()->can('edit payslip type')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
        if ($paysliptype->created_by !== Auth::user()->creatorId()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
        return view('paysliptype.edit', compact('paysliptype'));
    }

    public function update(Request $request, PayslipTypes $paysliptype)
    {
        if (!Auth::user()->can('edit payslip type')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        if ($paysliptype->created_by !== \Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $request->validate([
            'name' => 'required|max:20',
        ]);
        $paysliptype->name = $request->name;
        $paysliptype->save();
        return redirect()->route('paysliptype.index')->with('success', __('Payslip ' .$paysliptype->name. ' successfully updated.'));
    }

    public function destroy(PayslipTypes $paysliptype)
    {
        if (!Auth::user()->can('delete payslip type')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        if ($paysliptype->created_by !== Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $paysliptype->delete();
        return redirect()->route('paysliptype.index')->with('success', __('Payslip ' .$paysliptype->name. ' successfully deleted.'));
    }

}
