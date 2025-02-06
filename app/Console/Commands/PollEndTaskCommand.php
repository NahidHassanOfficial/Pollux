<?php
namespace App\Console\Commands;

use App\Events\PollResultNotifyEvent;
use App\Models\Poll;
use Illuminate\Console\Command;

class PollEndTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:handle-expire-poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $polls = Poll::whereStatus('active')->where('expire_at', '<=', now())->get();

        foreach ($polls as $poll) {
            $poll->update(['status' => 'inactive']);
            event(new PollResultNotifyEvent($poll->id));
        }

    }
}
