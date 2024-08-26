<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchedule extends EditRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function getFooterWidgets(): array
    {
        return [
            ScheduleResource\Widgets\CalendarWidget::class,
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
