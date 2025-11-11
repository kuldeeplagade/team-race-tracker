@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Race</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('races.update', $race->id) }}" method="POST" id="raceForm" class="mb-4">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Race Name</label>
            <input type="text" name="race_name" value="{{ $race->race_name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $race->description }}</textarea>
        </div>

        <button class="btn btn-primary">Update Race</button>
        <a href="{{ route('races.index') }}"
           class="btn btn-secondary {{ $race->checkpoints->count() < 3 ? 'disabled' : '' }}"
           title="{{ $race->checkpoints->count() < 3 ? 'Add at least 3 checkpoints to finish' : '' }}">
           Back to List
        </a>
    </form>

    <hr>

    <h4>Checkpoints</h4>
    <form action="{{ route('checkpoints.store', $race->id) }}" method="POST" class="row g-3 mb-3">
        @csrf
        <div class="col-md-6">
            <input type="text" name="checkpoint_name" class="form-control" placeholder="Checkpoint name" required>
        </div>
        <div class="col-md-3">
            <button class="btn btn-success w-100">Add Checkpoint</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order</th>
                <th>Checkpoint Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($race->checkpoints->sortBy('order_no') as $checkpoint)
                <tr>
                    <td>{{ $checkpoint->order_no }}</td>
                    <td>{{ $checkpoint->checkpoint_name }}</td>
                    <td>
                        <form action="{{ route('checkpoints.destroy', [$race->id, $checkpoint->id]) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this checkpoint?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const checkpointCount = {{ $race->checkpoints->count() }};
    const form = document.getElementById('raceForm');

    form.addEventListener('submit', (e) => {
        if (checkpointCount < 3) {
            e.preventDefault();
            alert('⚠️ Please add at least 3 checkpoints before updating the race.');
        }
    });
});
</script>
@endsection
