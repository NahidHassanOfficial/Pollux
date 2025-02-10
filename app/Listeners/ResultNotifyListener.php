<?php
namespace App\Listeners;

use App\Events\PollResultNotifyEvent;
use App\Models\Poll;
use App\Models\User;
use App\Notifications\PollEndNotification;
use App\Notifications\PollResultMailNotification;
use Illuminate\Support\Facades\Notification;

class ResultNotifyListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PollResultNotifyEvent $event): void
    {
        $poll = $event->poll->load('pollOptions:poll_id,option,votes');

        $optionResult = $poll->pollOptions->toArray();
        foreach ($optionResult as &$option) {
            $votes                = $option['votes'];
            $option['percentage'] = ($poll->total_vote > 0) ? round(($votes / $poll->total_vote) * 100, 2) : 0;
        }

        $poll_data = [
            'title'      => $poll->title,
            'total_vote' => $poll->total_vote,
            'result'     => $optionResult,
        ];

        $user = User::find($poll->user_id);
        $user->notify(new PollEndNotification($poll));
        Notification::send($user, new PollResultMailNotification($poll_data));

    }
}
