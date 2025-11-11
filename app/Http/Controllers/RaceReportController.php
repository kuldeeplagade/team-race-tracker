<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\RaceLog;
use Illuminate\Http\Request;

class RaceReportController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Fix: order by race_name (not name)
        $races = Race::orderBy('race_name')->get();
        $selectedRace = $request->race_id;

        $memberReports = collect();
        $teamReports = collect();

        if ($selectedRace) {
            // --- Member-level report ---
            $memberReports = RaceLog::where('race_id', $selectedRace)
                ->select('member_id')
                ->distinct()
                ->with(['member.team'])
                ->get()
                ->map(function ($member) use ($selectedRace) {
                    $logs = RaceLog::where('race_id', $selectedRace)
                        ->where('member_id', $member->member_id)
                        ->with('checkpoint')
                        ->orderBy('checkpoint_id')
                        ->get();

                    $times = $logs->mapWithKeys(function ($log) {
                        return [$log->checkpoint->checkpoint_name => $log->reached_at];
                    });

                    $start = $logs->first()?->reached_at;
                    $end = $logs->last()?->reached_at;

                    $duration = null;
                    if ($start && $end) {
                        $startTime = \Carbon\Carbon::parse($start);
                        $endTime = \Carbon\Carbon::parse($end);
                        $duration = $startTime->diff($endTime);
                    }

                    return [
                        'member' => $member->member->member_name ?? 'Unknown',
                        'team' => $member->member->team->team_name ?? '-',
                        'times' => $times,
                        'total_time' => $duration ? sprintf(
                            '%d days, %02d:%02d:%02d',
                            $duration->d,
                            $duration->h,
                            $duration->i,
                            $duration->s
                        ) : 'Incomplete',
                        'total_seconds' => $duration ? ($duration->days * 86400 + $duration->h * 3600 + $duration->i * 60 + $duration->s) : null,
                    ];
                })
                ->filter(fn($m) => $m['total_seconds'] !== null)
                ->sortBy('total_seconds')
                ->values();

            // --- Team Ranking Report ---
            $teamReports = $memberReports
                ->groupBy('team')
                ->map(function ($members, $teamName) {
                    $avgSeconds = $members->avg('total_seconds');
                    return [
                        'team' => $teamName,
                        'avg_seconds' => $avgSeconds,
                        'avg_time' => gmdate('H:i:s', $avgSeconds),
                    ];
                })
                ->sortBy('avg_seconds')
                ->values();
        }

        return view('race_reports.index', compact('races', 'selectedRace', 'memberReports', 'teamReports'));
    }
}
