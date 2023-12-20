<?php

namespace App\Notifications;

use App\Mail\UserFeedbackMail;
use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeedbackNotification extends Notification
{
    use Queueable;

    private Feedback $feedback;

    /**
     * Create a new notification instance.
     */
    public function __construct(Feedback $feedback)
    {
        $feedback->loadMissing([
            "user",
            "track",
        ]);
        $this->feedback = $feedback;
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
        $source = $this->feedback->user->name;
        $dest = $this->feedback->track->user->email;
        $message = $this->feedback->message;
        $track_id = $this->feedback->track->id;
        // Not from Mailer
        return (new MailMessage)
            ->from("soundstore@gmail.com")
            ->replyTo($dest)
            ->line("Un nouveau feedback a été envoyé par $source")
            ->line("Message: $message")
            ->action('Aller au feedback', url("http://local.soundstore.com/track/$track_id"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "feedback" => $this->feedback->toArray(),
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            "feedback" => $this->feedback->toArray(),
        ];
    }

    public function databaseType(object $notifiable): string
    {
        return 'feedback';
    }
}
