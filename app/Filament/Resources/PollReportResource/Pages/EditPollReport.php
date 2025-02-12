<?php

namespace App\Filament\Resources\PollReportResource\Pages;

use App\Filament\Resources\PollReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPollReport extends EditRecord
{
    protected static string $resource = PollReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
