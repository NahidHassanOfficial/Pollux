<?php
namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PollEndNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $poll)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'poll_uid' => $this->poll->poll_uid,
            'title'    => $this->poll->title,
            'message'  => 'This poll has been ended. Check your mail for result or visit the poll',
        ];
    }

    public function toBroadcast($notifiable)
    {
        \Log::info('Broadcasting PollEndNotification for user ID: ' . $this->poll->user_id);

        return new BroadcastMessage([
            'poll_uid' => $this->poll->poll_uid,
            'title'    => $this->poll->title,
            'message'  => 'This poll has been ended. Check your mail for result or visit the poll',
        ]);
    }

    public function broadcastOn(): array
    {

        return [
            new PrivateChannel('pollEnd-Notification.' . $this->poll->user_id),
        ];
    }

    public function broadcastAs()
    {
        return 'pollEndEvent';
    }

}
