<?php

namespace App\Mail;

use App\Message;
use App\MessageReply;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageReplyReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $sender;

    /**
     * @var User
     */
    public $receiver;

    /**
     * @var Message
     */
    public $newMessage;
    /**
     * @var MessageReply
     */
    public $messageReply;

    /**
     * Create a new message instance.
     * @param User $sender
     * @param User $receiver
     * @param Message $newMessage
     * @param MessageReply $messageReply
     */
    public function __construct(User $sender, User $receiver, Message $newMessage, MessageReply $messageReply)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->newMessage = $newMessage;
        $this->messageReply = $messageReply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Create subject
        $subject = 'Message Received From ' . $this->sender->pretty_name() .' on '. $this->newMessage->title;

        // User view to send mail
        return $this->subject($subject)
            ->view('emails.message-reply-received');
    }
}
