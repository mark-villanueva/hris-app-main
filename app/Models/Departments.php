<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departments extends Model
{
    public function positions(): HasMany
    {
        return $this->hasMany(Positions::class);
    }

    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
