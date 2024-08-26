<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements FilamentUser
{
    use HasRoles;
    use HasPanelShield;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class);
    }

    public function leaverequest(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function payroll(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }
    public function payslip(): HasMany
    {
        return $this->hasMany(Payslip::class);
    }

    public function salary(): HasMany
    {
        return $this->hasMany(Salary::class);
    }

    public function announcement(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }
}
