@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Add Member</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('members.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Member Name</label>
            <input type="text" name="member_name" class="form-control" value="{{ old('member_name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Team</label>
            <select name="team_id" class="form-select" required>
                <option value="">— Select Team —</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->team_name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Create Member</button>
        <a href="{{ route('members.index') }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection
