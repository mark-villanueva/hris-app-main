<?php

namespace App\Filament\Resources\PayslipResource\Pages;

use App\Filament\Resources\PayslipResource;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Filament\Widgets\EmployeeOverview;

class ViewPayslip extends Page
{
    protected static string $resource = PayslipResource::class;
    protected static string $view = 'filament.resources.payslip-resource.pages.view-payslip';

    public $user;
    public $employee;
    public $regularHours;
    public $overtimeHours;
    public $grossPay;
    public $deductions;
    public $allowance;
    public $netPay;

    public function mount(): void
    {
        $userId = Route::current()->parameter('record');
        $this->user = User::findOrFail($userId);
        $this->employee = Employee::where('user_id', $userId)->with('salary')->first();
    
        $userPresentDays = EmployeeOverview::getUserPresentDays();
        $totalRegularHours = EmployeeOverview::getTotalRegularHours();
        $totalOvertimeHours = EmployeeOverview::getTotalOvertimeHours();
    
        $this->regularHours = $totalRegularHours[$userId] ?? 0;
        $this->overtimeHours = $totalOvertimeHours[$userId] ?? 0;
    
        $this->regularPay = $this->calculateRegularPay($userId, $this->regularHours);
        $this->overtimePay = $this->calculateOvertimePay($userId, $this->overtimeHours);
        $this->grossPay = $this->regularPay + $this->overtimePay;
        $this->deductions = $this->calculateDeductions($userId);
        $this->allowance = $this->employee->salary->nta ?? 0;
        $this->netPay = $this->grossPay - $this->deductions + $this->allowance;
    }
    
    protected function calculateRegularPay($userId, $regularHours): float
    {
        $employee = Employee::where('user_id', $userId)->first();
        $hourlyRate = $employee->salary->hourly_rate;
    
        return $regularHours * $hourlyRate;
    }
    
    protected function calculateOvertimePay($userId, $overtimeHours): float
    {
        $employee = Employee::where('user_id', $userId)->first();
        $otRate = $employee->salary->ot_rate;
    
        return $overtimeHours * $otRate;
    }
    
    public static function calculateGrossPay($userId, $regularHours, $overtimeHours): float
    {
        $employee = Employee::where('user_id', $userId)->first();
        $hourlyRate = $employee->salary->hourly_rate;
        $otRate = $employee->salary->ot_rate;

        $regularPay = $regularHours * $hourlyRate;
        $overtimePay = $overtimeHours * $otRate;

        return $regularPay + $overtimePay;
    }

    public static function calculateDeductions($userId): float
    {
        $employee = Employee::where('user_id', $userId)->first();
        $bir = $employee->salary->bir;
        $sss = $employee->salary->sss;
        $philhealth = $employee->salary->philhealth;
        $pagibig = $employee->salary->pagibig;

        return $bir + $sss + $philhealth + $pagibig;
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('downloadPdf')
                ->label('Download PDF')
                ->url(fn () => route('payslip.download', $this->user->id))
                ->color('primary')
        ];
    }

    protected function getViewData(): array
    {
        return [
            'user' => $this->user,
            'employee' => $this->employee,
            'regularHours' => $this->regularHours,
            'regularPay' => $this->regularPay,
            'overtimePay' => $this->overtimePay,
            'overtimeHours' => $this->overtimeHours,
            'grossPay' => $this->grossPay,
            'deductions' => $this->deductions,
            'allowance' => $this->allowance,
            'netPay' => $this->netPay,
        ];
    }
}
