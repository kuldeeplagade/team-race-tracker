@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Race</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('races.update', $race->id) }}" method="POST" class="mb-4">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Race Name</label>
            <input type="text" name="race_name" value="{{ $race->race_name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $race->description }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('races.index') }}" class="btn btn-secondary">Back</a>
    </form>

    <hr>

    <h4>Checkpoints</h4>
    <form action="{{ route('checkpoints.store', $race->id) }}" method="POST" class="row g-3 mb-3">
        @csrf
        <div class="col-md-6">
            <input type="text" name="checkpoint_name" class="form-control" placeholder="Checkpoint name" required>
        </div>
        <!-- <div class="col-md-3">
            <input type="number" name="order_no" class="form-control" placeholder="Order no." required>
        </div> -->
        <div class="col-md-3">
            <button class="btn btn-success w-100">Add Checkpoint</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order</th>
                <th>Checkpoint</th>
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
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this checkpoint?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
