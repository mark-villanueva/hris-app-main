<?php

namespace App\Filament\Resources\DepartmentsResource\Pages;

use App\Filament\Resources\DepartmentsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartments extends CreateRecord
{
    protected static string $resource = DepartmentsResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Department Successfully Created';
    }
}
