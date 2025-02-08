<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class UserStatsWidget extends BaseWidget
{

    protected function getStats(): array
    {
        $timeFrom = 60 * 5; // 5 minutes
        $timeTo   = 60 * 10; // 10 minutes
        $users = Cache::flexible('userStats', [$timeFrom, $timeTo], function () {
            return User::orderBy('created_at')->select('email_verified', 'suspended', 'created_at')->get();
        });

        //count users per date
        $chartData = $users->groupBy(function ($user) {
            return $user->created_at->toDateTimeString();
        })->map(function ($group) {
            return $group->count();
        });

        //filter values to array
        $usersPerDate = $chartData->values()->toArray();

        //count verified users based on email verified
        $verifiedUsers = $users->filter(function ($user) {
            return $user->email_verified == 1;
        })->count();

        //count suspended users
        $suspendedUsers = $users->filter(function ($user) {
            return $user->suspended == 1;
        })->count();

        return [
            Stat::make('Total User', array_sum($usersPerDate))
                ->description('Total Registered User')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart($usersPerDate),

            Stat::make('Verified User', $verifiedUsers)
                ->description('Email verified vser')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Suspended User', $suspendedUsers)
                ->description('Users suspended for violating Rules')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
