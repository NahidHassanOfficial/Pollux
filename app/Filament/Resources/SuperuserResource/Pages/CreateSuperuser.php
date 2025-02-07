<?php

namespace App\Filament\Resources\SuperuserResource\Pages;

use App\Filament\Resources\SuperuserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSuperuser extends CreateRecord
{
    protected static string $resource = SuperuserResource::class;
}
