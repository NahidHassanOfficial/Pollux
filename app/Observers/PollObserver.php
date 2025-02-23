<?php
namespace App\Observers;

use App\Models\Poll;
use App\Services\RedisCacheDeleteService;
use Illuminate\Support\Facades\Cache;

class PollObserver
{
    /**
     * Handle the Poll "created" event.
     */
    public function created(Poll $poll): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Poll "updated" event.
     */
    public function updated(Poll $poll): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Poll "deleted" event.
     */
    public function deleted(Poll $poll): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Poll "restored" event.
     */
    public function restored(Poll $poll): void
    {
        //
    }

    /**
     * Handle the Poll "force deleted" event.
     */
    public function forceDeleted(Poll $poll): void
    {
        //
    }

    protected function clearCache()
    {
        // defer(function () {
        //     DB::table('cache')->where('key', 'like', 'view_%')->delete();
        //     DB::table('cache')->where('key', 'like', 'feed_%')->delete();
        //     DB::table('cache')->where('key', 'like', 'activePoll_%')->delete();

        //     DB::table('cache')->where('key', 'pollStats')->delete();
        //     DB::table('cache')->where('key', 'pollStatsChart')->delete();
        // });

        defer(function () {
            RedisCacheDeleteService::wildcardDelete('view_*');
            RedisCacheDeleteService::wildcardDelete('feed_*');
            RedisCacheDeleteService::wildcardDelete('activePoll_*');

            Cache::forget('pollStats');
            Cache::forget('pollStatsChart');
        });
    }
}
