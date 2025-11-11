<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\RaceCheckpoint;
use Illuminate\Http\Request;

class RaceCheckpointController extends Controller
{
    public function store(Request $request, Race $race)
    {
        $request->validate([
            'checkpoint_name' => 'required|string|max:255',
        ]);

        $nextOrder = $race->checkpoints()->max('order_no') + 1;

        $race->checkpoints()->create([
            'checkpoint_name' => $request->checkpoint_name,
            'order_no' => $nextOrder,
        ]);

        return redirect()
            ->route('races.edit', $race->id)
            ->with('success', "Checkpoint '{$request->checkpoint_name}' added successfully (Order #{$nextOrder}).");
    }

    public function destroy(Race $race, RaceCheckpoint $checkpoint)
    {
        $checkpoint->delete();

        // Reorder remaining checkpoints
        $race->checkpoints()
            ->orderBy('order_no')
            ->get()
            ->each(function ($cp, $index) {
                $cp->update(['order_no' => $index + 1]);
            });

        return redirect()
            ->route('races.edit', $race->id)
            ->with('success', 'Checkpoint deleted and order updated successfully.');
    }
}
