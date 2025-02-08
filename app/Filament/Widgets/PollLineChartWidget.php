<?php

namespace App\Filament\Widgets;

use App\Models\Poll;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;

class PollLineChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $timeFrom = 60 * 5; // 5 minutes
        $timeTo   = 60 * 10; // 10 minutes
        $pollsByMonth = Cache::flexible('pollStatsChart', [$timeFrom, $timeTo], function () {
            return Poll::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        });

        $monthlyCounts = array_fill(0, 12, 0);
        foreach ($pollsByMonth as $poll) {
            $monthlyCounts[$poll->month - 1] = $poll->count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Poll created',
                    'data' => $monthlyCounts,
                    'backgroundColor' => '#8370f3',
                    'borderColor' => '#8370f3',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
