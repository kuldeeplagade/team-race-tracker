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
            'race_name' => 'required|string|max:255|unique:races,race_name',
            'description' => 'nullable|string',
        ], [
            'race_name.unique' => 'A race with this name already exists.',
        ]);

        $race = Race::create($request->only('race_name', 'description'));

        return redirect()
            ->route('races.edit', $race->id)
            ->with('success', 'Race created successfully. Please add at least 3 checkpoints before finalizing.');
    }

    public function edit(Race $race)
    {
        return view('races.edit', compact('race'));
    }

    public function update(Request $request, Race $race)
    {
        $request->validate([
            'race_name' => 'required|string|max:255|unique:races,race_name,' . $race->id,
            'description' => 'nullable|string',
        ], [
            'race_name.unique' => 'A race with this name already exists.',
        ]);

        $race->update($request->only('race_name', 'description'));

        // ✅ Backend restriction
        if ($race->checkpoints()->count() < 3) {
            return redirect()
                ->route('races.edit', $race->id)
                ->with('error', 'Each race must have at least 3 checkpoints. Please add more checkpoints before updating.');
        }

        return redirect()->route('races.index')->with('success', 'Race updated successfully.');
    }

    public function destroy(Race $race)
    {
        $race->checkpoints()->delete();
        $race->delete();

        return redirect()->route('races.index')->with('success', 'Race deleted successfully.');
    }
}
