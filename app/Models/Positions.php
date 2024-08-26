<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Positions extends Model
{
    public function departments(): BelongsTo
    {
        return $this->belongsTo(Departments::class);
    }

    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
