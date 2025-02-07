<?php

namespace App\Filament\Resources\SuperuserResource\Pages;

use App\Filament\Resources\SuperuserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuperusers extends ListRecords
{
    protected static string $resource = SuperuserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
