<?php

namespace App\Filament\Resources\DepartmentsResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PositionsRelationManager extends RelationManager
{
    protected static string $relationship = 'positions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('position')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'Hiring' => 'Hiring',
                        'Interviewing' => 'Interviewing',
                        'Onboarding' => 'Onboarding',
                        'Pending Approval' => 'Pending Approval'
                    ]),
                Forms\Components\TextArea::make('description')
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('position')
            ->columns([
                Tables\Columns\TextColumn::make('position'),
                Tables\Columns\TextColumn::make('status'), 
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('created_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
