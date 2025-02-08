<?php

namespace App\Filament\Resources\PollResource\Pages;

use App\Filament\Resources\PollResource;
use App\Filament\Widgets\ActivePollStatsWidget;
use App\Filament\Widgets\DashboardStatsWidget;
use App\Filament\Widgets\PollStatsWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPolls extends ListRecords
{
    protected static string $resource = PollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PollStatsWidget::class
        ];
    }
}
