<?php

namespace App\Events;

use App\Models\Resource;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactRequestEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Resource $resource, public array $data)
    {

    }
}
