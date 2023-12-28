<?php

namespace App\Listeners;

use App\Events\CommentEvent;
use App\Events\ContactRequestEvent;
use App\Mail\UserContactMail;
use Illuminate\Events\Dispatcher;
use Illuminate\Mail\Mailer;

class ContactRequestEventSubscriber
{
    public function __construct(private Mailer $mailer){
    }
    public function sendEmail(ContactRequestEvent $event){
        $this->mailer->send(new UserContactMail($event->resource, $event->data));
    }
    public function subscribe(Dispatcher $dispatcher){
        $dispatcher->listen(
            ContactRequestEvent::class,
            [ContactRequestEventSubscriber::class, 'sendEmail']
        );
    }
}
