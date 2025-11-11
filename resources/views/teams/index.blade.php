@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Teams</h3>
        <a href="{{ route('teams.create') }}" class="btn btn-primary">+ Add Team</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Team Name</th>
                        <th>Members</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teams as $team)
                        <tr>
                            <td>{{ $team->id }}</td>
                            <td><a href="{{ route('teams.show', $team) }}">{{ $team->team_name }}</a></td>
                            <td>{{ $team->members_count }}</td>
                            <td>
                                <a href="{{ route('teams.edit', $team) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form action="{{ route('teams.destroy', $team) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete team? All members will be removed.');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No teams yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $teams->links() }}
    </div>
</div>
@endsection
