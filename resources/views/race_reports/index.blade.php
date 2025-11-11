@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">🏁 Race Reports</h2>

    <form method="GET" action="{{ route('race.reports') }}" class="row mb-4">
        <div class="col-md-4">
            <label for="race_id" class="form-label">Select Race</label>
            <select name="race_id" id="race_id" class="form-select" required>
                <option value="">-- Select Race --</option>
                @foreach($races as $race)
                    <option value="{{ $race->id }}" {{ $selectedRace == $race->id ? 'selected' : '' }}>
                        {{ $race->race_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Generate
            </button>
        </div>
    </form>

    @if($selectedRace)
        <h4 class="mb-3">Member Results</h4>
        <div class="table-responsive mb-5">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Team</th>
                        <th>Checkpoint Times</th>
                        <th>Total Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($memberReports as $index => $m)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $m['member'] }}</td>
                            <td>{{ $m['team'] }}</td>
                            <td>
                                @foreach($m['times'] as $cp => $time)
                                    <div><strong>{{ $cp }}:</strong> {{ $time }}</div>
                                @endforeach
                            </td>
                            <td><strong>{{ $m['total_time'] }}</strong></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No completed members yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h4 class="mb-3">🏆 Team Rankings</h4>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Rank</th>
                        <th>Team</th>
                        <th>Average Completion Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teamReports as $i => $team)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $team['team'] }}</td>
                            <td>{{ $team['avg_time'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">No team data available.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
