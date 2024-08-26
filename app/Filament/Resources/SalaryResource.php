<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryResource\Pages;
use App\Filament\Resources\SalaryResource\RelationManagers;
use App\Models\Salary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalaryResource extends Resource
{
    protected static ?string $model = Salary::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Admin Panel';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('daily_rate')
                    ->label('Daily Rate')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('hourly_rate')
                    ->label('Hourly Rate')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('bir')
                    ->label('BIR')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('sss') 
                    ->label('SSS')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('philhealth')
                    ->label('PhilHealth')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pagibig')
                    ->label('Pag-Ibig')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ot_rate')
                    ->label('OT Rate')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nta')
                    ->label('Non-Taxable Allowance')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('daily_rate')
                    ->label('Daily Rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hourly_rate')
                    ->label('Hourly Rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bir')
                    ->label('BIR')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sss')
                    ->label('SSS')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('philhealth')
                    ->label('PhilHealth')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pagibig')
                    ->label('Pag-Ibig')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ot_rate')
                    ->label('OT Rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nta')
                    ->label('Non-Taxable Allowance')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSalaries::route('/'),
            'create' => Pages\CreateSalary::route('/create'),
            'edit' => Pages\EditSalary::route('/{record}/edit'),
        ];
    }
}
