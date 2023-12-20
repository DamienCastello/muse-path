<?php

namespace App\Notifications;

use App\Models\Track;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use phpDocumentor\Reflection\Types\Boolean;

class LikeTrackNotification extends Notification
{
    use Queueable;

    private Track $track;

    /**
     * Create a new notification instance.
     */
    public function __construct(Track $track, bool $likeValue)
    {
        $track->loadMissing([
            "users",
        ]);
        $this->track = $track;
        $this->likeValue = $likeValue;
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
        $dest = $this->track->user->name;
        $verb = $this->likeValue ? "aime" : "n'aime pas" ;
        $title = $this->track->title;
        $track_id = $this->track->id;
        // Not from Mailer
        return (new MailMessage)
            ->from("soundstore@gmail.com")
            ->replyTo($this->track->user->email)
            ->line("L'utilisateur $dest $verb votre track $title")
            ->action('Aller à la track', url("http://local.soundstore.com/track/$track_id"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "track" => $this->track->toArray(),
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            "track" => $this->track->toArray(),
        ];
    }

    public function databaseType(object $notifiable): string
    {
        return 'like_track';
    }
}
