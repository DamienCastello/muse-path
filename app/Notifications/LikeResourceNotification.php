<?php

namespace App\Notifications;

use App\Models\Resource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use phpDocumentor\Reflection\Types\Boolean;

class LikeResourceNotification extends Notification
{
    use Queueable;

    private Resource $resource;

    /**
     * Create a new notification instance.
     */
    public function __construct(Resource $resource, array $user, bool $likeValue)
    {
        $resource->loadMissing([
            "users",
        ]);
        $this->resource = $resource;
        $this->likeValue = $likeValue;
        $this->source = $user;
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
        $email_source = $this->source['email'];
        $name_source = $this->source['name'];
        $dest = $this->resource->user->email;
        $verb = $this->likeValue ? "aime" : "n'aime pas" ;
        $title = $this->resource->title;
        $slug = $this->resource->slug;
        $resource_id = $this->resource->id;
        // Not from Mailer
        return (new MailMessage)
            ->from("soundstore@gmail.com")
            ->replyTo($dest)
            ->line("L'utilisateur $name_source $verb votre resource $title")
            ->action('Aller au resource', url("http://local.soundstore.com/resource/$slug"."-$resource_id"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "resource" => $this->resource->toArray(),
            "source" => $this->source,
            "status" => $this->likeValue
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            "resource" => $this->resource->toArray(),
            "source" => $this->source,
            "status" => $this->likeValue
        ];
    }

    public function databaseType(object $notifiable): string
    {
        return 'like_resource';
    }
}
