<?php

namespace App\Filament\Widgets;

use App\Models\LeaveRequest;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Salary;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;

class EmployeeOverview extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Presents', $this->getTotalPresents()), 
            Stat::make('Absents', $this->getTotalAbsents()), 
            Stat::make('Lates', $this->getTotalLates()),
            Stat::make('On Leave', $this->getTotalApprovedLeaveRequests())
        ];
    }

    protected function getTotalPresents(): int
    {
        $timezone = 'Asia/Manila';
        $today = Carbon::now()->timezone($timezone)->toDateString();
        return Schedule::whereDate('time_in', $today)
            ->distinct('user_id')
            ->count('user_id');
    }

    protected function getTotalAbsents(): int
    {
        $totalUsers = $this->getTotalUsers();
        $totalPresents = $this->getTotalPresents();
        return $totalUsers - $totalPresents;
    }

    protected function getTotalLates(): int
    {
        return Schedule::where(function ($query) {
                    $query->whereRaw('TIME(time_in) > TIME(start_shift)')
                          ->whereRaw('DATE(time_in) = DATE(start_date)');
                })
                ->count();
    }

    protected function getTotalApprovedLeaveRequests(): int
    {
        return LeaveRequest::where('status', 'approved')->count();
    }

    protected function getTotalUsers(): int
    {
        return User::count();
    }
    
    public static function getUserPresentDays($startDate = null, $endDate = null): array
    {
        $query = Schedule::select('user_id', DB::raw('COUNT(DISTINCT DATE(time_in)) as days_present'))
            ->groupBy('user_id');

        if ($startDate && $endDate) {
            $query->whereBetween('time_in', [$startDate, $endDate]);
        }

        return $query->get()
            ->pluck('days_present', 'user_id')
            ->toArray();
    }

    public static function getTotalRegularHours($startDate = null, $endDate = null): array
    {
        $query = Schedule::select('user_id', DB::raw('ROUND(SUM(TIME_TO_SEC(TIMEDIFF(time_out, time_in)) / 3600), 2) as total_hours'))
            ->groupBy('user_id');

        if ($startDate && $endDate) {
            $query->whereBetween('time_in', [$startDate, $endDate]);
        }

        return $query->get()
            ->pluck('total_hours', 'user_id')
            ->toArray();
    }

    public static function getTotalOvertimeHours($startDate = null, $endDate = null): array
    {
        $query = Schedule::select('user_id', DB::raw('ROUND(SUM(TIME_TO_SEC(TIMEDIFF(TIME(time_out), end_shift)) / 3600), 2) as total_overtime_hours'))
            ->whereRaw('TIME(time_out) > end_shift')
            ->whereDate('time_out', 'end_date')
            ->groupBy('user_id');

        if ($startDate && $endDate) {
            $query->whereBetween('time_out', [$startDate, $endDate]);
        }

        return $query->get()
            ->pluck('total_overtime_hours', 'user_id')
            ->toArray();
    }
}
