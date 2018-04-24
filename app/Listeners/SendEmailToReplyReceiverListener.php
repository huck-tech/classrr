<?php

namespace App\Listeners;

use App\Events\MessageReplyCreated;
use App\Mail\MessageReplyReceived;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailToReplyReceiverListener
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
     * @param MessageReplyCreated $messageReplyCreated
     */
    public function handle(MessageReplyCreated $messageReplyCreated)
    {
        // Get message reply from event
        $messageReply = $messageReplyCreated->messageReply;

        // Get related message
        $message = $messageReply->message;

        // Get sender
        $sender = User::find($messageReply->sender_id);

        // Get receiver id
        $receiverId = ($message->receiver_id == $sender->id)?$message->sender_id:$message->receiver_id;

        // Get receiver
        $receiver = User::find($receiverId);

        // Get receiver email
        $to = $receiver->email;

        // Send email
        Mail::to($to)->send(new MessageReplyReceived($sender, $receiver, $message, $messageReply));
    }
}
