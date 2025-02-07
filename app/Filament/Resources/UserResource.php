<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use OpenSpout\Common\Entity\Cell\BooleanCell;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([

                    Tab::make('Profile')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Section::make('Profile Info')->schema([
                                TextInput::make('username')->unique(ignoreRecord: true)->required()->readOnlyOn('create'),
                                TextInput::make('email')->email()->required(),
                                TextInput::make('password')->password()->revealable()
                                    ->dehydrated(fn($state) => filled($state)), // Only save if not empty
                            ]),
                        ]),

                    Tab::make('Suspend')
                        ->icon('heroicon-o-no-symbol')
                        ->schema([
                            Section::make('Suspend')->schema([
                                Checkbox::make('suspended')->extraAttributes(['class' => 'text-center']),
                            ]),
                        ]),

                    Tab::make('Avatar')
                        ->icon('heroicon-o-link')
                        ->schema([
                            Section::make()->schema([
                                TextInput::make('profile_img')->label('Image URL')->placeholder('Enter image url')->url(),
                            ]),
                        ])

                ])->columnSpanFull()->persistTabInQueryString()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_img'),
                TextColumn::make('username')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('email_verified'),
                TextColumn::make('penalty'),
                TextColumn::make('suspended')->sortable(),
                TextColumn::make('total_poll')->sortable(),
                TextColumn::make('created_at')->sortable(),
            ])
            ->filters([
                SelectFilter::make('email_verified')
                    ->label('Verified User')
                    ->options([
                        '1' => 'Verified',
                        '0' => 'Unverified',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Return false to disable the button
    }
}
