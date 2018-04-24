<?php

namespace App\Events;

use App\MessageReply;
use Illuminate\Queue\SerializesModels;

class MessageReplyCreated
{
    use SerializesModels;

    /**
     * @var MessageReply
     */
    public $messageReply;

    /**
     * Create a new event instance.
     *
     * @param MessageReply $messageReply
     */
    public function __construct(MessageReply $messageReply)
    {
        $this->messageReply = $messageReply;
    }
}
