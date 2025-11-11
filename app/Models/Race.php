<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Race extends Model
{
    protected $fillable = ['race_name', 'description'];

    public function checkpoints(): HasMany
    {
        return $this->hasMany(RaceCheckpoint::class)->orderBy('order_no');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(RaceLog::class);
    }
}
