<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Models\User;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Payroll;
use App\Filament\Widgets\EmployeeOverview;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use Filament\Tables\Enums\FiltersLayout;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 5;
    protected static ?string $title = 'Payroll';
    protected static ?string $navigationLabel = 'Payroll';
    protected ?string $heading = 'Payroll';
    protected static ?string $navigationGroup = 'Admin Panel';

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return User::query()
                    ->join('employees', 'users.id', '=', 'employees.user_id')
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
                    ->getStateUsing(function (User $record) {
                        $userPresentDays = EmployeeOverview::getUserPresentDays(
                            Request::query('tableFilters.date_range.start_date'),
                            Request::query('tableFilters.date_range.end_date')
                        );
                        return $userPresentDays[$record->id] ?? 0;
                    }),
                Tables\Columns\TextColumn::make('total_regular_hours')
                    ->label('Regular Hours')
                    ->sortable()
                    ->getStateUsing(function (User $record) {
                        $totalRegularHours = EmployeeOverview::getTotalRegularHours(
                            Request::query('tableFilters.date_range.start_date'),
                            Request::query('tableFilters.date_range.end_date')
                        );
                        return $totalRegularHours[$record->id] ?? 0;
                    }),
                Tables\Columns\TextColumn::make('total_overtime_hours')
                    ->label('OT Hours')
                    ->sortable()
                    ->getStateUsing(function (User $record) {
                        $totalOvertimeHours = EmployeeOverview::getTotalOvertimeHours(
                            Request::query('tableFilters.date_range.start_date'),
                            Request::query('tableFilters.date_range.end_date')
                        );
                        return $totalOvertimeHours[$record->id] ?? 0;
                    }),
                Tables\Columns\TextColumn::make('gross_pay')
                    ->label('Gross Pay')
                    ->getStateUsing(function (User $record) {
                        $userId = $record->id;
                        $totalRegularHours = EmployeeOverview::getTotalRegularHours(
                            Request::query('tableFilters.date_range.start_date'),
                            Request::query('tableFilters.date_range.end_date')
                        );
                        $totalOvertimeHours = EmployeeOverview::getTotalOvertimeHours(
                            Request::query('tableFilters.date_range.start_date'),
                            Request::query('tableFilters.date_range.end_date')
                        );

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
                    ->getStateUsing(function (User $record) {
                        $userId = $record->id;
                        $totalRegularHours = EmployeeOverview::getTotalRegularHours(
                            Request::query('tableFilters.date_range.start_date'),
                            Request::query('tableFilters.date_range.end_date')
                        );
                        $totalOvertimeHours = EmployeeOverview::getTotalOvertimeHours(
                            Request::query('tableFilters.date_range.start_date'),
                            Request::query('tableFilters.date_range.end_date')
                        );

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
                Filter::make('date_range')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Salary Cut Off Start Date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Salary Cut Off End Date')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->query(function (Builder $query, array $data) {
                        if (isset($data['start_date']) && isset($data['end_date'])) {
                            $startDate = $data['start_date'];
                            $endDate = $data['end_date'];
                            $query->whereHas('schedule', function (Builder $query) use ($startDate, $endDate) {
                                $query->whereBetween('time_in', [$startDate, $endDate]);
                            });
                        }
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Relations here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayrolls::route('/'),
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
