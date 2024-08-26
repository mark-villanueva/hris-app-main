<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leaverequest(): HasMAny
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
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
