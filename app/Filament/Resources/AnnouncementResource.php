<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Carbon;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationGroup = 'Admin Panel';

    public static function form(Form $form): Form
    {
        $user = Auth::user(); // Get the authenticated user here
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextArea::make('announcement')
                    ->autosize()
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(3000),
                Forms\Components\Hidden::make('user_id')
                    ->default($user->getKey()) // Set the default value to the authenticated user's ID
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                Tables\Columns\TextColumn::make('title')
                    ->weight(FontWeight::Bold)
                    ->searchable(),
                Panel::make([
                Tables\Columns\TextColumn::make('announcement')
                    ->limit(240)
                    ->searchable(),
                ])->collapsible(),
                // Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 1,
            ])
            ->filters([
                Filter::make('today')
                    ->label('Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', Carbon::today())),
                Filter::make('this_week')
                    ->label('This Week')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])),
                Filter::make('this_month')
                    ->label('This Month')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
