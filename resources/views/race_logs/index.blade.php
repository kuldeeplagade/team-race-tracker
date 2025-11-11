@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Race Logs</h3>
    <a href="{{ route('race_logs.create') }}" class="btn btn-primary mb-3">+ Add Log</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Race</th>
                <th>Member</th>
                <th>Checkpoint</th>
                <th>Reached At</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                @php
                    $lastCheckpoint = $log->race->checkpoints->sortBy('order_no')->last();
                    $isCompleted = $lastCheckpoint && $log->checkpoint_id == $lastCheckpoint->id;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $log->race->race_name }}</td>
                    <td>{{ $log->member->member_name }}</td>
                    <td>{{ $log->checkpoint->checkpoint_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->reached_at)->format('d M Y, h:i A') }}</td>
                    <td>
                        @if($isCompleted)
                            <span class="badge bg-success">🏁 Completed</span>
                        @else
                            <span class="badge bg-warning text-dark">In Progress</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
    