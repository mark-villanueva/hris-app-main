<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Filament\Widgets\EmployeeOverview;
use Barryvdh\DomPDF\Facade\Pdf;

class PayslipController extends Controller
{
    public function downloadPdf($record)
    {
        $user = User::findOrFail($record);
        $employee = Employee::where('user_id', $record)->with('salary')->first();
        
        $totalRegularHours = EmployeeOverview::getTotalRegularHours();
        $totalOvertimeHours = EmployeeOverview::getTotalOvertimeHours();
        
        $regularHours = $totalRegularHours[$record] ?? 0;
        $overtimeHours = $totalOvertimeHours[$record] ?? 0;
        
        $regularPay = $this->calculateRegularPay($record, $regularHours);
        $overtimePay = $this->calculateOvertimePay($record, $overtimeHours);
        $grossPay = $regularPay + $overtimePay;
        $deductions = $this->calculateDeductions($record);
        $allowance = $employee->salary->nta ?? 0;
        $netPay = $grossPay - $deductions + $allowance;
        
        $data = [
            'user' => $user,
            'employee' => $employee,
            'regularHours' => $regularHours,
            'regularPay' => $regularPay,
            'overtimePay' => $overtimePay,
            'overtimeHours' => $overtimeHours,
            'grossPay' => $grossPay,
            'deductions' => $deductions,
            'allowance' => $allowance,
            'netPay' => $netPay,
        ];
        
        $pdf = Pdf::loadView('payslip.pdf', $data);
        return $pdf->download('payslip.pdf');
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
    
    protected function calculateDeductions($userId): float
    {
        $employee = Employee::where('user_id', $userId)->first();
        $bir = $employee->salary->bir;
        $sss = $employee->salary->sss;
        $philhealth = $employee->salary->philhealth;
        $pagibig = $employee->salary->pagibig;

        return $bir + $sss + $philhealth + $pagibig;
    }
}
