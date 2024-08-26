<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentsResource\Pages;
use App\Filament\Resources\DepartmentsResource\RelationManagers;
use App\Models\Departments;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentsResource extends Resource
{
    protected static ?string $model = Departments::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Admin Panel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('department')
                    ->required()
                    ->label('Department Name'),
                TextInput::make('manager')
                    ->required(),
                TextArea::make('description')
                    ->columnSpan('full'),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('department')
                    ->label('Department Name'),
                TextColumn::make('manager'),
                TextColumn::make('description')
                    ->wrap(),
                TextColumn::make('created_at')
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
            RelationManagers\PositionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartments::route('/create'),
            'edit' => Pages\EditDepartments::route('/{record}/edit'),
        ];
    }
}
