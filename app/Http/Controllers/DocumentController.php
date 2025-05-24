<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use League\CommonMark\Node\Block\Document;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        // echo $user->name;;die;
        if($user->can('manage document type'))
        {
            $documents = Documents::where('created_by', '=', $user->creatorId())->get();
            return view('document.index', compact('documents'));
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
        if(auth()->user()->can('create document type'))
        {
            return view('document.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(auth()->user()->can('create document type'))
        {
            $validator=$request->validate([
                'name'        => 'required|string|max:255',
                'is_required' => 'required|in:0,1',
            ]);
            $document              = new Documents();
            // print_r($document);die;
            $document->name        = $request->name;
            $document->is_required = $request->is_required;
            $document->created_by  = auth()->user()->creatorId();
            $document->save();
            return redirect()->route('document.index')->with('success', __('Document type successfully created.'));
        }
        else
        {
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
    public function edit(Documents $document)
    {
        // echo $document->created_by;die;
        if(auth()->user()->can('edit document type'))
        {
            if($document->created_by == auth()->user()->creatorId())
            {
                return view('document.edit', compact('document'));
            }else{
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }else{
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Documents $document)
    {
        $user = auth()->user();
        if (!$user->can('edit document type')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        if ($document->created_by !== $user->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'is_required' => 'required|in:0,1',
        ]);
        $document->update($validated);
        return redirect()->route('document.index')->with('success', __('Document type successfully updated.'));
    }

    public function destroy(Documents $document)
    {
        $user = auth()->user();
        if (!$user->can('delete document type')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        if ($document->created_by !== $user->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $document->delete();
        return redirect()->route('document.index')->with('success', __('Document type successfully deleted.'));
    }

}
