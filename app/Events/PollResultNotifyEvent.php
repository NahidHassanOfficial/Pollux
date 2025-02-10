<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PollResultNotifyEvent
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

}
