<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RaceLog extends Model
{
    protected $fillable = ['race_id', 'member_id', 'checkpoint_id', 'reached_at'];

    protected $dates = ['reached_at'];

    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'member_id');
    }

    public function checkpoint(): BelongsTo
    {
        return $this->belongsTo(RaceCheckpoint::class, 'checkpoint_id');
    }
}
