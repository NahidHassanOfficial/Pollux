<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PollResource\Pages;
use App\Filament\Resources\PollResource\RelationManagers;
use App\Models\Poll;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Card as ComponentsCard;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PollResource extends Resource
{
    protected static ?string $model = Poll::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Title & Description')->schema([
                    TextInput::make('title'),
                    Textarea::make('description')->rows(5),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make()->schema([
                        Radio::make('status')->options([
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                            'restricted' => 'Restricted',
                        ]),

                    ]),

                    DateTimePicker::make('expire_at'),
                ])->columnSpan(1),

                Section::make('Poll Options')->schema([
                    Repeater::make('pollOptions')
                        ->relationship('pollOptions')
                        ->schema([
                            TextInput::make('option')->required(),
                        ])->maxItems(0) // Prevent item creation
                ])

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('status'),
                TextColumn::make('total_visitor'),
                TextColumn::make('total_vote'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
                TextColumn::make('expire_at')->dateTime()->sortable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'restricted' => 'Restricted'
                    ])
                    ->attribute('status')
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
            'index' => Pages\ListPolls::route('/'),
            'create' => Pages\CreatePoll::route('/create'),
            'edit' => Pages\EditPoll::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Return false to disable the button
    }
}
