<?php

namespace App\Listeners;

use App\Events\CommentEvent;
use App\Mail\UserCommentMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;

class CommentListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private Mailer $mailer)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentEvent $event): void
    {
        $this->mailer->send(new UserCommentMail($event->resource, $event->data));
    }
}
