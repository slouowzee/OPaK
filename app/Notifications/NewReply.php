<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReply extends Notification
{
    use Queueable;

    public function __construct(protected Message $reply)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'reply',
            'message_id' => $this->reply->id,
            'parent_id' => $this->reply->parent_id,
            'user_name' => $this->reply->user->name,
            'content' => $this->reply->content,
        ];
    }
}
