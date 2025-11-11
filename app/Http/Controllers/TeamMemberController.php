<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = TeamMember::with('team')->orderBy('id','desc')->paginate(12);
        return view('members.index', compact('members'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::orderBy('team_name')->get();
        return view('members.create', compact('teams'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'member_name' => 'required|string|max:255',
        ]);

        TeamMember::create($data);

        return redirect()->route('members.index')->with('success', 'Member added to team.');
    }


    /**
     * Display the specified resource.
     */
    public function show(TeamMember $member)
    {
        $member->load('team');
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeamMember $member)
    {
        $teams = Team::orderBy('team_name')->get();
        return view('members.edit', compact('member','teams'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeamMember $member)
    {
        $data = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'member_name' => 'required|string|max:255',
        ]);

        // If you later add race_id and want to prevent switching race, enforce here.
        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Member updated.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamMember $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member removed.');
    }

}
