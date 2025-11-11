@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Add New Race</h3>

    <form action="{{ route('races.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Race Name</label>
            <input type="text" name="race_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('races.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
