<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // optional, see notes
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('conversation', 'sender');
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'conversation_id' => $this->message->conversation->id,
            'message_id' => $this->message->id,
            'sender_id' => $this->message->sender->id,
            'sender_name' => $this->message->sender->name,
            'excerpt' => \Illuminate\Support\Str::limit($this->message->message, 120),
        ];
    }

    public function toMail($notifiable)
    {
        $url = url(route('conversations.show', $this->message->conversation->id));

        return (new MailMessage)
            ->subject('New message on CouponMart')
            ->greeting("Hello {$notifiable->name},")
            ->line("You have a new message from {$this->message->sender->name}.")
            ->line(\Illuminate\Support\Str::limit($this->message->message, 400))
            ->action('View Conversation', $url)
            ->line('Reply to keep the conversation going.');
    }
}
