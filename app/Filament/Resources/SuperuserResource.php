<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuperuserResource\Pages;
use App\Filament\Resources\SuperuserResource\RelationManagers;
use App\Models\Superuser;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuperuserResource extends Resource
{
    protected static ?string $model = Superuser::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
                TextInput::make('password')->password()
                    ->required(fn(string $operation): bool => $operation === 'create') // Required only on create
                    ->dehydrated(fn($state) => filled($state)), // Only save if not empty
                Select::make('role')->options([
                    'admin' => 'Admin',
                    'moderator' => 'Moderator',
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('role'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuperusers::route('/'),
            // disabled pages to get modal view
            // 'create' => Pages\CreateSuperuser::route('/create'),
            // 'edit' => Pages\EditSuperuser::route('/{record}/edit'),
        ];
    }
}
