<?php
namespace App\Filament\Resources\PollReportResource\Pages;

use App\Filament\Resources\PollReportResource;
use App\Models\PollReport;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Cache;

class ListPollReports extends ListRecords
{
    protected static string $resource = PollReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Pending'    => Tab::make()
                ->icon('heroicon-o-clock')
                ->query(function ($query) {
                    return $query->where('report_status', 'pending');
                })
                ->badge(Cache::flexible('pendingReportCount', [60 * 1, 60 * 3], function () {
                    return PollReport::where('report_status', 'pending')->count();
                }))
                ->badgeColor('warning'),

            'Resolved'   => Tab::make()
                ->icon('heroicon-o-check-circle')
                ->query(function ($query) {
                    return $query->where('report_status', 'resolved');
                }),

            'Restricted' => Tab::make()
                ->icon('heroicon-o-shield-exclamation')
                ->query(function ($query) {
                    return $query->where('restrict_poll', 1);
                }),

            'All'        => Tab::make()
                ->icon('heroicon-o-circle-stack'),
        ];
    }

}