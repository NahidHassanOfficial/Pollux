<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PollReportResource\Pages;
use App\Models\PollReport;
use App\Models\User;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PollReportResource extends Resource
{
    protected static ?string $model = PollReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function getNavigationBadge(): ?string
    {
        $count = Cache::flexible('pendingReportCount', [60 * 1, 60 * 3], function () {
            return PollReport::where('report_status', 'pending')->count();
        });
        return $count > 0 ? (string) $count : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('poll.title')
                    ->label('Poll Title')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($record) =>
                        '<a href="' . route('pollPage', $record->poll->poll_uid) . '" target="_blank"
                            class=" text-[#8370f3]">' . e($record->poll->title) . ' </a>')
                    ->html(),

                TextColumn::make('reason')->searchable(),
                TextColumn::make('description')->limit(20)->tooltip(fn($record) => $record->description),

                TextColumn::make('reporter_ip')->label('Reporter IP')->searchable()->toggleable(),
                TextColumn::make('created_at')->label('Reported at')->date()->sortable()->toggleable(),
                TextColumn::make('updated_at')->label('Resolved at')->date()->sortable()->toggleable(),
                TextColumn::make('admin_note')->label('Resolve Note')->toggleable(),
                TextColumn::make('superuser.name')->label('Resolve By')->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([

                //resolve reported poll as resolved
                Action::make('resolveReport')
                    ->label('Mark as Resolved')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->form([
                        Textarea::make('admin_note')
                            ->label('Admin Note')
                            ->required()
                            ->placeholder('Enter resolution note...'),
                    ])
                    ->action(function (PollReport $record, array $data) {
                        $superuserId = Auth::id();

                        PollReport::where('poll_id', $record->poll_id)
                            ->where('report_status', 'pending')
                            ->update([
                                'report_status' => 'resolved',
                                'admin_note'    => $data['admin_note'],
                                'superuser_id'  => $superuserId,
                            ]);

                    }),

                //restrict reported poll
                Action::make('restrictPoll')
                    ->label('Restrict Poll')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->form([
                        Textarea::make('admin_note')
                            ->label('Restriction Reason')
                            ->required()
                            ->placeholder('Enter restriction reason...'),
                    ])
                    ->action(function (PollReport $record, array $data) {
                        $superuserId = Auth::id();

                        PollReport::where('poll_id', $record->poll_id)
                            ->where('report_status', 'pending')
                            ->update([
                                'report_status' => 'resolved',
                                'admin_note'    => $data['admin_note'],
                                'superuser_id'  => $superuserId,
                                'restrict_poll' => true,
                            ]);

                        if ($record->poll) {
                            $userID = $record->poll->user_id;
                            $user   = User::find($userID);
                            $user->increment('penalty');

                            if ($user->penalty >= 3) {
                                $record->poll->update([
                                    'suspended' => true,
                                ]);
                            }

                            $record->poll->update([
                                'status' => 'restricted',
                            ]);

                        }

                    }),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListPollReports::route('/'),
            // 'create' => Pages\CreatePollReport::route('/create'),
            // 'edit'  => Pages\EditPollReport::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Return false to disable the button
    }

}