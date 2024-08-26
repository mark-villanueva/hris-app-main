<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Salary extends Model
{
    use HasFactory;

    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function payroll(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    public function payslip(): HasMany
    {
        return $this->hasMany(Payslip::class);
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
