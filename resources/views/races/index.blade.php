@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Races</h3>
    <a href="{{ route('races.create') }}" class="btn btn-primary mb-3">+ Add Race</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Race Name</th>
                <th>Description</th>
                <th>Checkpoints</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($races as $race)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $race->race_name }}</td>
                    <td>{{ $race->description }}</td>
                    <td>
                        @foreach($race->checkpoints as $cp)
                            <span class="badge bg-info text-dark">{{ $cp->order_no }}. {{ $cp->checkpoint_name }}</span><br>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('races.edit', $race->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('races.destroy', $race->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this race?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
