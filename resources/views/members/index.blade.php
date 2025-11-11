@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Team Members</h3>
        <a href="{{ route('members.create') }}" class="btn btn-primary">+ Add Member</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member Name</th>
                        <th>Team</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $m)
                        <tr>
                            <td>{{ $m->id }}</td>
                            <td>{{ $m->member_name }}</td>
                            <td>{{ $m->team->team_name ?? '—' }}</td>
                            <td>
                                <a href="{{ route('members.edit', $m) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form action="{{ route('members.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete member?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No members yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $members->links() }}
    </div>
</div>
@endsection
