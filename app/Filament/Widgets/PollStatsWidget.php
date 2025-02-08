<?php

namespace App\Filament\Widgets;

use App\Models\Poll;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class PollStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {

        $timeFrom = 60 * 5; // 5 minutes
        $timeTo   = 60 * 10; // 10 minutes
        $polls = Cache::flexible('pollStats', [$timeFrom, $timeTo], function () {
            return Poll::orderBy('created_at')->select('status', 'total_visitor', 'created_at')->get();
        });

        //count polls per date
        $chartData = $polls->groupBy(function ($poll) {
            return $poll->created_at->toDateTimeString();
        })->map(function ($group) {
            return $group->count();
        });

        //filter values to array
        $pollsPerDate = $chartData->values()->toArray();

        //count active polls
        $activePolls = $polls->filter(function ($poll) {
            return $poll->status == 'active';
        })->count();

        //count total poll visitor
        $totalVisitors  = $polls->sum('total_visitor');

        return [
            Stat::make('Total Poll', array_sum($pollsPerDate))
                ->chart($pollsPerDate)
                ->description('Total polls created')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make('Active Poll', $activePolls)
                ->description('Current active polls')
                ->descriptionIcon('heroicon-m-fire')
                ->color('success'),

            Stat::make('Total Poll Visitor', $totalVisitors)
                ->description('Total visitor count of all poll')
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
        ];
    }
}
