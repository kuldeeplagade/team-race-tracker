@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Add Race Log</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('race_logs.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Race</label>
            <select name="race_id" id="race_id" class="form-select" required>
                <option value="">Select Race</option>
                @foreach($races as $race)
                    <option value="{{ $race->id }}">{{ $race->race_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Member</label>
            <select name="member_id" class="form-select" required>
                <option value="">Select Member</option>
                @foreach($members as $m)
                    <option value="{{ $m->id }}">{{ $m->member_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Checkpoint</label>
            <select name="checkpoint_id" id="checkpoint_id" class="form-select" required>
                <option value="">Select Checkpoint</option>
                @foreach($races as $r)
                    @foreach($r->checkpoints as $cp)
                        <option value="{{ $cp->id }}" data-race="{{ $r->id }}" style="display:none;">
                            {{ $cp->order_no }}. {{ $cp->checkpoint_name }}
                        </option>
                    @endforeach
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Reached At</label>
            <input type="datetime-local" name="reached_at" class="form-control" required>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('race_logs.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
document.getElementById('race_id').addEventListener('change', function() {
    const raceId = this.value;
    document.querySelectorAll('#checkpoint_id option').forEach(opt => {
        opt.style.display = (opt.dataset.race == raceId || opt.value == '') ? 'block' : 'none';
    });
    document.getElementById('checkpoint_id').value = '';
});
</script>
@endsection
