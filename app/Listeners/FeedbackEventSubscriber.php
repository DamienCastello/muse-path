<?php

namespace App\Listeners;

use App\Events\FeedbackEvent;
use App\Mail\UserFeedbackMail;
use Illuminate\Events\Dispatcher;
use Illuminate\Mail\Mailer;

class FeedbackEventSubscriber
{
    public function __construct(private Mailer $mailer){
    }

    public function sendEmail(FeedbackEvent $event){
        $this->mailer->send(new UserFeedbackMail($event->track, $event->data));
    }

    public function subscribe(Dispatcher $dispatcher){
        $dispatcher->listen(
            FeedbackEvent::class,
            [FeedbackEventSubscriber::class, 'sendEmail']
        );
    }
}
