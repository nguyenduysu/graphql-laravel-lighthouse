<?php

namespace App\Notifications;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentCreatedNotification extends Notification
{
    use Queueable;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }


    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'notificationCommentCreated' => $this->comment
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'notificationCommentCreated' => $this->comment
        ]);
    }
}
