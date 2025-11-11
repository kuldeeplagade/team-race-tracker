<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = ['team_name'];

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }
}
