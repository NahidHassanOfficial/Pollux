<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PollResultNotifyEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $poll;
    /**
     * Create a new event instance.
     */
    public function __construct($poll)
    {
        $this->poll = $poll;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('pollEnd-Notification.' . $this->poll->user_id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'poll_uid' => $this->poll->poll_uid,
            'title'    => $this->poll->title,
            'message'  => 'This poll has been ended. Check your mail for result or visit the poll',
        ];
    }

    public function broadcastAs()
    {
        return 'pollEndEvent';
    }
}
