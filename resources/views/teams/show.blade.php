@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>{{ $team->team_name }}</h3>
        <a href="{{ route('members.create') }}" class="btn btn-outline-primary">Add Member</a>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Members</h5>
            <ul class="list-group">
                @forelse($team->members as $m)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $m->member_name }}
                        <span>
                            <a href="{{ route('members.edit', $m) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('members.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete member?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </span>
                    </li>
                @empty
                    <li class="list-group-item">No members yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
