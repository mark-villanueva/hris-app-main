<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PayslipResource\Pages;
use App\Filament\Resources\PayslipResource\RelationManagers;
use App\Models\Payslip;
use App\Models\User;
use App\Models\Employee;
use App\Filament\Widgets\EmployeeOverview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PayslipResource extends Resource
{
    protected static ?string $model = Payslip::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 4;

    public static function table(Table $table): Table
    {
        $userPresentDays = EmployeeOverview::getUserPresentDays();
        $totalRegularHours = EmployeeOverview::getTotalRegularHours();
        $totalOvertimeHours = EmployeeOverview::getTotalOvertimeHours();

        return $table
            ->query(function () {
                $userId = Auth::id(); // Get the authenticated user's ID
                return User::query()
                    ->join('employees', 'users.id', '=', 'employees.user_id')
                    ->where('users.id', $userId) // Filter by authenticated user's ID
                    ->select('users.*', 'employees.*');
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Employee')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('days_present')
                    ->label('Days Present')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($userPresentDays) {
                        return $userPresentDays[$record->id] ?? 0;
                    }),
                Tables\Columns\TextColumn::make('total_regular_hours')
                    ->label('Regular Hours')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($totalRegularHours) {
                        return $totalRegularHours[$record->id] ?? 0;
                    }),
                Tables\Columns\TextColumn::make('total_overtime_hours')
                    ->label('OT Hours')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($totalOvertimeHours) {
                        return $totalOvertimeHours[$record->id] ?? 0;
                    }),
                Tables\Columns\TextColumn::make('gross_pay')
                    ->label('Gross Pay')
                    ->getStateUsing(function (User $record) use ($totalRegularHours, $totalOvertimeHours) {
                        $userId = $record->id;
                        $regularHours = $totalRegularHours[$userId] ?? 0;
                        $overtimeHours = $totalOvertimeHours[$userId] ?? 0;

                        return self::calculateGrossPay($userId, $regularHours, $overtimeHours);
                    }),
                Tables\Columns\TextColumn::make('deductions')
                    ->label('Deductions')
                    ->sortable()
                    ->getStateUsing(function (User $record) {
                        return self::calculateDeductions($record->id);
                    }),
                Tables\Columns\TextColumn::make('allowance')
                    ->label('Allowance')
                    ->sortable()
                    ->getStateUsing(function (User $record) {
                        $employee = Employee::where('user_id', $record->id)->with('salary')->first();
                        return $employee->salary->nta ?? 0;
                    }),
                Tables\Columns\TextColumn::make('net_pay')
                    ->label('Net Pay')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($totalRegularHours, $totalOvertimeHours) {
                        $userId = $record->id;
                        $regularHours = $totalRegularHours[$userId] ?? 0;
                        $overtimeHours = $totalOvertimeHours[$userId] ?? 0;
                        $grossPay = self::calculateGrossPay($userId, $regularHours, $overtimeHours);
                        $deductions = self::calculateDeductions($userId);
                        $employee = Employee::where('user_id', $userId)->with('salary')->first();
                        $nta = $employee->salary->nta ?? 0;

                        return $grossPay - $deductions + $nta;
                    }),
            ])
            ->filters([
                // Filters here
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayslips::route('/'),
            'view' => Pages\ViewPayslip::route('/{record}/view'),
        ];
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
}
