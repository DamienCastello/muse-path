<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;

    private Comment $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment)
    {
        $comment->loadMissing([
            "user",
            'resource'
        ]);
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $source = $this->comment->user->name;
        $dest = $this->comment->resource->user->email;
        $content = $this->comment->content;
        $track_id = $this->comment->resource->id;
        $slug = $this->comment->resource->slug;
        // Not from Mailer
        return (new MailMessage)
            ->from("soundstore@gmail.com")
            ->replyTo($dest)
            ->line("Un nouveau commentaire a été envoyé par $source")
            ->line("Message: $content")
            ->action('Aller à la ressource', url("http://local.soundstore.com/resource/$slug"."-$track_id"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'comment' => $this->comment->toArray()
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'comment' => $this->comment->toArray()
        ];
    }

        public function databaseType(object $notifiable): string
    {
        return 'comment';
    }
}
