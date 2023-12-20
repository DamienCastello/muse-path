<?php

namespace App\Listeners;

use App\Events\CommentEvent;
use App\Mail\UserCommentMail;
use Illuminate\Events\Dispatcher;
use Illuminate\Mail\Mailer;

class CommentEventSubscriber
{
    public function __construct(private Mailer $mailer){
    }
    public function sendEmail(CommentEvent $event){
        $this->mailer->send(new UserCommentMail($event->resource, $event->data));
    }
    public function subscribe(Dispatcher $dispatcher){
        $dispatcher->listen(
            CommentEvent::class,
            [CommentEventSubscriber::class, 'sendEmail']
        );
    }
}
