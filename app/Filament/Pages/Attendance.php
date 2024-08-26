<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Schedule;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Attendance extends Page implements HasForms, HasTable
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.attendance';

    use InteractsWithTable;
    use InteractsWithForms;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Schedule::where('user_id', Auth::id()))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Employee')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_shift')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return Carbon::parse($record->start_shift)->format('h:i A');
                    }),                
                Tables\Columns\TextColumn::make('end_shift')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return Carbon::parse($record->end_shift)->format('h:i A');
                    }),
                Tables\Columns\TextColumn::make('time_in')
                    ->label('Time In')
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_out')
                    ->label('Time Out')
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_late')
                    ->label('Late')
                    ->getStateUsing(function ($record) {
                        $startShift = Carbon::parse($record->start_date . ' ' . $record->start_shift);
                        $timeIn = Carbon::parse($record->time_in);
                        return $timeIn->greaterThan($startShift) ? 'Yes' : 'No';
                    }),
                Tables\Columns\TextColumn::make('is_overtime')
                    ->label('Overtime')
                    ->getStateUsing(function ($record) {
                        $endShift = Carbon::parse($record->start_date . ' ' . $record->end_shift);
                        $timeOut = Carbon::parse($record->time_out);
                
                        // Check if the date of time_out matches end_date
                        if ($timeOut->toDateString() !== $record->end_date) {
                            return 'No';
                        }
                
                        return $timeOut->greaterThan($endShift) ? 'Yes' : 'No';
                    }),
                
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Tables\Actions\Action::make('time_in')
                    ->label('Time In')
                    ->action(function ($record) {
                        $record->update(['time_in' => Carbon::now()->timezone('Asia/Manila')]);
                    })
                    ->hidden(fn ($record) => $record->time_in !== null), // Hide if already clocked in
                Tables\Actions\Action::make('time_out')
                    ->label('Time Out')
                    ->action(function ($record) {
                        $record->update(['time_out' => Carbon::now()->timezone('Asia/Manila')]);
                    })
                    ->hidden(fn ($record) => $record->time_in === null || $record->time_out !== null), // Hide if not clocked in or already clocked out
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function getTotalLates(): int
    {
        return Schedule::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->whereRaw('TIME(time_in) > TIME(start_shift)')
                      ->whereColumn('DATE(time_in)', 'DATE(start_date)');
            })
            ->count();
    }
}
