<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    public function departments(): BelongsTo
    {
        return $this->belongsTo(Departments::class);
    }

    public function positions(): BelongsTo
    {
        return $this->belongsTo(Positions::class);
    }

    public function salary(): BelongsTo
    {
        return $this->belongsTo(Salary::class);
    }

    public function schedules(): BelongsTo
    {
        return $this->belongsTo(Schedules::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payroll(): BelongsTo
    {
        return $this->belongsTo(Payroll::class);
    }

    public function payslip(): BelongsTo
    {
        return $this->belongsTo(Payslip::class);
    }
    
}
