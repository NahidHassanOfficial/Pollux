<?php
namespace App\Observers;

use App\Models\PollReport;
use Illuminate\Support\Facades\Cache;

class ReportObserver
{
    /**
     * Handle the PollReport "created" event.
     */
    public function created(PollReport $pollReport): void
    {
        $this->clearCache();
    }

    /**
     * Handle the PollReport "updated" event.
     */
    public function updated(PollReport $pollReport): void
    {
        $this->clearCache();
    }

    /**
     * Handle the PollReport "deleted" event.
     */
    public function deleted(PollReport $pollReport): void
    {
        //
    }

    /**
     * Handle the PollReport "restored" event.
     */
    public function restored(PollReport $pollReport): void
    {
        //
    }

    /**
     * Handle the PollReport "force deleted" event.
     */
    public function forceDeleted(PollReport $pollReport): void
    {
        //
    }

    protected function clearCache()
    {
        Cache::forget('pendingReportCount');
    }
}
