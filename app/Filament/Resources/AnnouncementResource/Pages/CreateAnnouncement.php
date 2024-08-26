<?php

namespace App\Filament\Resources\AnnouncementResource\Pages;

use App\Filament\Resources\AnnouncementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;
    protected static bool $canCreateAnother = false;
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Announcement Created';
    }
    
}
