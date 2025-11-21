<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Http\Request;

class TownController extends Controller
{
    public function index()
    {
        $towns = Town::orderBy('town_name')->get();
        return view('backend.admin.town.index', compact('towns'));
    }

    public function create()
    {
        return view('backend.admin.town.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'town_name' => 'required|string|max:255|unique:towns,town_name',
        ]);

        Town::create($validated);

        return redirect()->route('towns.index')->with('success', 'Town added successfully.');
    }

    public function edit(Town $town)
    {
        return view('backend.admin.town.edit', compact('town'));
    }

    public function update(Request $request, Town $town)
    {
        $validated = $request->validate([
            'town_name' => 'required|string|max:255|unique:towns,town_name,' . $town->id,
        ]);

        $town->update($validated);

        return redirect()->route('towns.index')->with('success', 'Town updated successfully.');
    }

    public function destroy(Town $town)
    {
        $town->delete();
        return redirect()->route('towns.index')->with('success', 'Town deleted successfully.');
    }
}
