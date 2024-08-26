<?php

namespace App\Filament\Resources\ScheduleResource\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Filament\Resources\ScheduleResource;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Schedule;
use Carbon\Carbon;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Schedule::class;

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
             ->mountUsing(
                 function (Forms\Form $form, array $arguments) {
                     $form->fill([
                         'start_date' => $arguments['start'] ?? null,
                         'end_date' => $arguments['end'] ?? null
                     ]);
                 }
             )
        ];
    }
 
    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
             ->mountUsing(
                 function (Schedule $record, Forms\Form $form, array $arguments) {
                     $form->fill([
                        'name' => $record->name . '   ' . Carbon::parse($record->start_shift)->format('h:i A') . '  ' . Carbon::parse($record->end_shift)->format('h:i A'),
                         'start_date' => $arguments['event']['start'] ?? $record->start_date,
                         'end_date' => $arguments['event']['end'] ?? $record->end_date
                     ]);
                 }
             ),
            Actions\DeleteAction::make(),
        ];
    }


    public function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->label('Employee')
                ->required(),
            Forms\Components\DatePicker::make('start_date'),
            Forms\Components\DatePicker::make('end_date'),

            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TimePicker::make('start_shift')
                        ->seconds(false),

                    Forms\Components\TimePicker::make('end_shift')
                        ->seconds(false),
                ]),
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Schedule::query()
            ->where('start_date', '>=', $fetchInfo['start'])
            ->where('end_date', '<=', $fetchInfo['end'])
            ->with('user') // Include the user relationship to fetch the name
            ->get()
            ->map(function (Schedule $schedule) {
                $startShift = Carbon::parse($schedule->start_shift)->format('h:i A');
                $endShift = Carbon::parse($schedule->end_shift)->format('h:i A');
    
                return [
                    'id' => $schedule->id,
                    'title' => $schedule->user->name . '   ' . $startShift . ' to ' . $endShift,
                    'start' => $schedule->start_date,
                    'end' => $schedule->end_date, // Combine date and time
                    // 'url' => ScheduleResource::getUrl(name: 'view', parameters: ['record' => $schedule]),
                    'shouldOpenUrlInNewTab' => true
                ];
            })
            ->all();
    }

    //tooltip 
    public function eventDidMount(): string
    {
        return <<<JS
            function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
                el.setAttribute("x-tooltip", "tooltip");
                el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
            }
        JS;
    }
}
