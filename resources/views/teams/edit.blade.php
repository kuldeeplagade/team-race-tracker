@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Edit Team</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teams.update', $team) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Team Name</label>
            <input type="text" name="team_name" class="form-control" value="{{ old('team_name', $team->team_name) }}" required>
        </div>
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('teams.index') }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection
