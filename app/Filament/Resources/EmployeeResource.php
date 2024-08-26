<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use App\Models\User;
use App\Models\Schedule;
use App\Filament\Widgets\EmployeeOverview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Employees';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Admin Panel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->required()
                    ->label('Sex')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->native(false),
                Forms\Components\DatePicker::make('birth_date')
                    ->required(),
                Forms\Components\Select::make('civil_status')
                    ->required()
                    ->options([
                        'single' => 'Single',
                        'married' => 'Married',
                        'widowed' => 'Widowed',
                        'divorced' => 'Divorced',
                    ])
                    ->native(false),
                Forms\Components\TextInput::make('mobile_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->columnSpan('full')
                    ->maxLength(255),
            Section::make()
            ->schema([
                Forms\Components\TextInput::make('tin')
                    ->label('TIN'),
                Forms\Components\TextInput::make('sss')
                    ->label('SSS'),
                Forms\Components\TextInput::make('philhealth')
                    ->label('Philhealth'),
                Forms\Components\TextInput::make('pagibig')
                    ->label('Pag-Ibig'),
                ])
                ->columns(4),
            Section::make('In case of emergency, contact:')
            ->schema([
                Forms\Components\TextInput::make('contact_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_number')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('relationship')
                    ->required()
                    ->maxLength(255),
                ])
                ->columns(3),
            Section::make('Employment Profile')
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User Name')
                    ->relationship('user', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('departments_id')
                    ->label('Department')
                    ->relationship('departments', 'department')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('positions_id')
                    ->label('Positions')
                    ->relationship('positions', 'position')
                    ->preload()
                    ->searchable()
                    ->required(),   
                Forms\Components\TextArea::make('description'),
                Forms\Components\Select::make('salary_id')
                    ->label('Salary Type')
                    ->relationship('salary', 'name')
                    ->preload()
                    ->searchable()
                    ->required(), 
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'Hired' => 'Hired',
                        'Probatioary' => 'Probatioary',
                        'Contract' => 'Contract'
                    ]),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
                ])
                ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        $userPresentDays = EmployeeOverview::getUserPresentDays();
        $totalRegularHours = EmployeeOverview::getTotalRegularHours();
        $totalOvertimeHours = EmployeeOverview::getTotalOvertimeHours();
        
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.id')
                    ->label('Id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('positions.position')
                    ->label('Position')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('departments.department')
                    ->label('Department')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('salary.id')
                    ->label('Salary Id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('salary.name')
                    ->label('Salary Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('salary.daily_rate')
                    ->label('Daily Rate')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                    BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    // public static function calculateGrossPay($userId, $regularHours, $overtimeHours): float
    // {
    //     $employee = Employee::where('user_id', $userId)->first();
    //     $hourlyRate = $employee->salary->hourly_rate;
    //     $otRate = $employee->salary->ot_rate;

    //     $regularPay = $regularHours * $hourlyRate;
    //     $overtimePay = $overtimeHours * $otRate;

    //     return $regularPay + $overtimePay;
    // }

}
