<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Announcements extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Announcement::query())
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('title')
                        ->weight(FontWeight::Bold),
                    Panel::make([
                        Tables\Columns\TextColumn::make('announcement')
                            ->limit(240),
                    ])->collapsible(),
                    Tables\Columns\TextColumn::make('created_at')
                        ->date(),
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
                ViewAction::make()
                    ->form([
                        Forms\Components\TextInput::make('title')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextArea::make('announcement')
                            ->autosize()
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(1024),
                    ]),
            ]);
    }
}
