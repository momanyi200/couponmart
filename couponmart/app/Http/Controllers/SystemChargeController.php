<?php

namespace App\Http\Controllers;

use App\Models\SystemCharge;
use App\Models\Category;
use Illuminate\Http\Request;

class SystemChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('backend.admin.system-charges.index', [
            'charges' => SystemCharge::with('category', 'addedBy')->paginate(10),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        //$categories = Category::all();   // << THIS POPULATES THE DROPDOWN
        $used = SystemCharge::pluck('cat_id')->toArray();
        $categories = Category::whereNotIn('id', $used)->get();

        return view('backend.admin.system-charges.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([            
            'cat_id'     => 'required|exists:categories,id|unique:system_charges,cat_id',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        SystemCharge::create([
            'cat_id' => $request->cat_id,
            'percentage' => $request->percentage,
            'added_by' => auth()->id(),
        ]);

       // return back()->with('success', 'System charge added successfully.');
        return redirect()
            ->route('system-charges.index')
            ->with('success', 'System charge added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SystemCharge $systemCharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    
    public function edit($id)
    {
        $charge = SystemCharge::findOrFail($id);
        $categories = Category::orderBy('cat_name')->get();

        return view('backend.admin.system-charges.edit', compact('charge', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([            
            'cat_id'     => 'required|exists:categories,id|unique:system_charges,cat_id,' . $id,
            'percentage'  => 'required|numeric|min:0|max:100',
        ]);

        $charge = SystemCharge::findOrFail($id);

        $charge->update([
            'cat_id' => $request->cat_id,
            'percentage'  => $request->percentage,
            'addedby'     => auth()->id(),   // Update the user who made the change
        ]);

        return redirect()
            ->route('system-charges.index')
            ->with('success', 'System charge updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemCharge $systemCharge)
    {
        //
        SystemCharge::findOrFail($id)->delete();

        return back()->with('success', 'Charge removed successfully.');
    }
}
