<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\RaceLog;
use App\Models\RaceCheckpoint;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RaceLogController extends Controller
{
    public function index()
    {
        $logs = RaceLog::with(['race', 'member', 'checkpoint'])->orderBy('reached_at', 'asc')->get();
        return view('race_logs.index', compact('logs'));
    }

    public function create()
    {
        $races = Race::with(['checkpoints' => function($q) {
            $q->orderBy('order_no', 'asc');
        }])->get();

        $members = TeamMember::orderBy('member_name', 'asc')->get();

        return view('race_logs.create', compact('races', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'race_id' => 'required|exists:races,id',
            'member_id' => 'required|exists:team_members,id',
            'checkpoint_id' => 'required|exists:race_checkpoints,id',
            'reached_at' => 'required|date',
        ]);

        $raceId = $request->race_id;
        $memberId = $request->member_id;
        $checkpointId = $request->checkpoint_id;
        $reachedAt = \Carbon\Carbon::parse($request->reached_at);

        // Load related records
        $member = \App\Models\TeamMember::find($memberId);
        $checkpoint = \App\Models\RaceCheckpoint::with('race')->find($checkpointId);
        $race = \App\Models\Race::with('checkpoints')->find($raceId);

        // Basic sanity checks
        if (!$member || !$checkpoint || !$race) {
            return back()->with('error', 'Invalid data provided.')->withInput();
        }

        // Ensure checkpoint belongs to the selected race
        if ($checkpoint->race_id != $raceId) {
            return back()->with('error', 'Selected checkpoint does not belong to the chosen race.')->withInput();
        }

        // Ensure member not assigned to a different race (if you store race_id on member)
        if (!empty($member->race_id) && $member->race_id != $raceId) {
            return back()->with('error', 'This member is already assigned to another race.')->withInput();
        }

        // Or: if member has logs in a different race => block
        $otherRaceLog = \App\Models\RaceLog::where('member_id', $memberId)
            ->where('race_id', '!=', $raceId)
            ->exists();
        if ($otherRaceLog) {
            return back()->with('error', 'This member has race logs for another race and cannot join this race.')->withInput();
        }

        // Get order_no for selected checkpoint
        $orderNo = (int) $checkpoint->order_no;

        // Check immediate previous checkpoint existence requirement (no skipping)
        if ($orderNo > 1) {
            $prevCheckpoint = \App\Models\RaceCheckpoint::where('race_id', $raceId)
                ->where('order_no', $orderNo - 1)
                ->first();

            if (!$prevCheckpoint) {
                // Data integrity: previous checkpoint missing in DB
                return back()->with('error', 'Checkpoint sequence is invalid (previous checkpoint missing).')->withInput();
            }

            // Ensure member has logged the previous checkpoint
            $prevLogged = \App\Models\RaceLog::where('race_id', $raceId)
                ->where('member_id', $memberId)
                ->where('checkpoint_id', $prevCheckpoint->id)
                ->exists();

            if (!$prevLogged) {
                return back()->with('error', "You must log checkpoint #".($orderNo - 1)." before logging this one.")->withInput();
            }
        } else {
            // orderNo == 1: ensure member hasn't already started at another checkpoint (safety)
            $anyLog = \App\Models\RaceLog::where('race_id', $raceId)
                ->where('member_id', $memberId)
                ->exists();
            // It's okay if they had no logs; if they have logs, still fine (maybe re-logging start is blocked later by duplicate)
        }

        // If logging the final checkpoint, ensure all previous checkpoints were logged
        $lastOrder = (int) $race->checkpoints->max('order_no');
        if ($orderNo === $lastOrder) {
            $requiredCount = $lastOrder - 1; // number of previous checkpoints that must be present
            $loggedCount = \App\Models\RaceLog::where('race_id', $raceId)
                ->where('member_id', $memberId)
                ->whereIn('checkpoint_id', $race->checkpoints->pluck('id')->toArray())
                ->distinct('checkpoint_id')
                ->count();

            if ($loggedCount < $requiredCount) {
                return back()->with('error', 'Member must complete all prior checkpoints before marking the final checkpoint.')->withInput();
            }
        }

        // Ensure new reached_at is not earlier than the member's last logged time
        $lastLog = \App\Models\RaceLog::where('race_id', $raceId)
            ->where('member_id', $memberId)
            ->orderBy('reached_at', 'desc')
            ->first();

        if ($lastLog && $reachedAt->lt(\Carbon\Carbon::parse($lastLog->reached_at))) {
            return back()->with('error', 'Reached time cannot be before the last checkpoint time.')->withInput();
        }

        // Attempt to create and handle duplicate DB error with friendly message
        try {
            \App\Models\RaceLog::create([
                'race_id' => $raceId,
                'member_id' => $memberId,
                'checkpoint_id' => $checkpointId,
                'reached_at' => $reachedAt,
            ]);

            return redirect()->route('race_logs.index')->with('success', 'Race log added successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            // 23000 is common SQLSTATE for integrity constraint violation (duplicate)
            if ($e->getCode() == 23000) {
                return back()->with('error', 'This member has already logged this checkpoint for this race.')->withInput();
            }
            return back()->with('error', 'Something went wrong while saving the log.')->withInput();
        }
    }


}
