<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    protected static bool $canCreateAnother = false;

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
