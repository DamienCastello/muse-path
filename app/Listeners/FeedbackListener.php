<?php

namespace App\Listeners;

use App\Events\FeedbackEvent;
use App\Mail\UserFeedbackMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;

class FeedbackListener
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
    public function handle(FeedbackEvent $event): void
    {
        $this->mailer->send(new UserFeedbackMail($event->track, $event->data));
    }
}
