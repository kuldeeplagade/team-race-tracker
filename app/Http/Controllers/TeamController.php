<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::withCount('members')->orderBy('id','desc')->paginate(10);
        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'team_name' => 'required|string|max:255|unique:teams,team_name',
        ]);

        Team::create($data);

        return redirect()->route('teams.index')->with('success', 'Team created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $team->load('members');
        return view('teams.show', compact('team'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('teams.edit', compact('team'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $data = $request->validate([
            'team_name' => 'required|string|max:255|unique:teams,team_name,' . $team->id,
        ]);

        $team->update($data);

        return redirect()->route('teams.index')->with('success', 'Team updated.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Team deleted.');
    }

}
