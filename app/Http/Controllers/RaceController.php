<?php

namespace App\Http\Controllers;

use App\Models\Race;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    public function index()
    {
        $races = Race::with('checkpoints')->latest()->get();
        return view('races.index', compact('races'));
    }

    public function create()
    {
        return view('races.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'race_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Race::create($request->only('race_name', 'description'));
        return redirect()->route('races.index')->with('success', 'Race created successfully.');
    }

    public function edit(Race $race)
    {
        return view('races.edit', compact('race'));
    }

    public function update(Request $request, Race $race)
    {
        $request->validate([
            'race_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $race->update($request->only('race_name', 'description'));
        return redirect()->route('races.index')->with('success', 'Race updated successfully.');
    }

    public function destroy(Race $race)
    {
        $race->checkpoints()->delete(); // delete checkpoints first
        $race->delete();
        return redirect()->route('races.index')->with('success', 'Race deleted successfully.');
    }
}
