<?php

namespace App\Listeners;

use App\Events\MessageReplyCreated;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRelatedMessageListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param MessageReplyCreated $messageReplyCreated
     * @return void
     * @internal param MessageReplyCreated $event
     */
    public function handle(MessageReplyCreated $messageReplyCreated)
    {
        // Get message reply from event
        $messageReply = $messageReplyCreated->messageReply;

        // Get related message
        $message = $messageReply->message;

        // Set updated_at date to now
        $message->updated_at = Carbon::now();

        // Set last reply id to this reply id
        $message->last_reply_id = $messageReply->id;

        // Save message
        $message->save();
    }
}
